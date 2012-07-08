<?php
namespace Neutron\TreeBundle\Model;

use Doctrine\ORM\EntityManager;

use Neutron\TreeBundle\Tree\TreeModelInterface;

class TreeManager implements TreeManagerInterface 
{
    protected $em;
    
    protected $class;
    
    protected $repository;
    
    
    public function __construct(EntityManager $em, $class)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository($class);
        $metadata = $this->em->getClassMetadata($class);
        $this->class = $metadata->name;
    }
    
    public function isRoot(TreeModelInterface $node)
    {
        $metadata = $this->em->getClassMetadata(get_class($node));
        return $metadata->getReflectionProperty('parent')->getValue($node) ? false : true;
    }


    public function createNode()
    {
        $class = $this->class;
        return new $class();
    }
    
    public function findNodeBy(array $filter)
    {
        return $this->repository->findOneBy($filter);
    }
    
    public function updateNode(TreeModelInterface $node)
    {
        $this->em->flush($node);
    }
    
    public function deleteNode(TreeModelInterface $node)
    {
        $this->repository->removeFromTree($node);
        $this->em->flush();
        $this->em->clear();
    }
    
    public function persistAsFirstChildOf(TreeModelInterface $node, TreeModelInterface $parent)
    {
        $this->repository->persistAsFirstChildOf($node, $parent);
        $this->em->flush();
    }
    
    public function persistAsLastChildOf(TreeModelInterface $node, TreeModelInterface $parent)
    {
        $this->repository->persistAsLastChildOf($node, $parent);
        $this->em->flush();
    }
}