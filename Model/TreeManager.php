<?php
namespace Neutron\TreeBundle\Model;

use Doctrine\ORM\EntityManager;

use Neutron\TreeBundle\Model\TreeNodeInterface;

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
    
    public function isRoot(TreeNodeInterface $node)
    {
        $metadata = $this->em->getClassMetadata(get_class($node));
        return $metadata->getReflectionProperty('parent')->getValue($node) ? false : true;
    }
    
    public function isLeaf(TreeNodeInterface $node)
    {
        return ($this->repository->childCount($node, true) > 0) ? true : false;
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
    
    public function getRoot()
    {
        $roots = $this->repository->getRootNodes();
        
        if (count($roots) > 0){
            return $roots[0];
        }
    }
    
    public function getChildren(TreeNodeInterface $node)
    {
        return $this->repository->children($node, true);
    }
    
    public function persistNode(TreeNodeInterface $node)
    {
        $this->em->persist($node);
        $this->em->flush($node);
    }
    
    public function updateNode(TreeNodeInterface $node)
    {
        $this->em->flush($node);
    }
    
    public function deleteNode(TreeNodeInterface $node)
    {
        $this->em->remove($node);
        $this->em->flush();
    }
    
    public function removeNodeFromTree(TreeNodeInterface $node)
    {
        $this->repository->removeFromTree($node);
        $this->em->flush();
        $this->em->clear();
    }
    
    public function persistAsFirstChildOf(TreeNodeInterface $node, TreeNodeInterface $parent)
    {
        $this->repository->persistAsFirstChildOf($node, $parent);
        $this->em->flush();
    }
    
    public function persistAsLastChildOf(TreeNodeInterface $node, TreeNodeInterface $parent)
    {
        $this->repository->persistAsLastChildOf($node, $parent);
        $this->em->flush();
    }
    
    public function persistAsPrevSiblingOf(TreeNodeInterface $node, TreeNodeInterface $sibling)
    {
        $this->repository->persistAsPrevSiblingOf($node, $sibling);
        $this->em->flush();
    }
    
    public function persistAsNextSiblingOf(TreeNodeInterface $node, TreeNodeInterface $sibling)
    {
        $this->repository->persistAsNextSiblingOf($node, $sibling);
        $this->em->flush();
    }
}