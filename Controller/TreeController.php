<?php

namespace Neutron\TreeBundle\Controller;

use Neutron\TreeBundle\Tree\TreeInterface;

use Symfony\Component\HttpFoundation\Response;

use Neutron\TreeBundle\Entity\Category;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TreeController extends Controller
{
    public function dataAction($name)
    {
        $tree = $this->getTree($name);
        $nodeId = (int) $this->getRequest()->get('nodeId', 0);
        
        $data = $this->getNodes($tree, $nodeId);
        
        return new Response(json_encode($data));
    }
    
    public function moveAction($name)
    {
        $tree = $this->getTree($name);
        $nodeId = $this->getRequest()->get('nodeId', false);
        $refId = $this->getRequest()->get('refId', false);
        $position = $this->getRequest()->get('position', false);
        
        $positions = array(
            'before' => 'persistAsPrevSiblingOf',
            'after' => 'persistAsNextSiblingOf',
            'last' => 'persistAsLastChildOf',
            'first' => 'persistAsFirstChildOf'
        );
        
        return new Response(json_encode(array()));
    }
    
    private function getTree($name)
    {
        if (! $this->getRequest()->isXmlHttpRequest()) {
            throw new \RuntimeException('Request must be XmlHttpRequest');
        }
    
        $provider = $this->get('neutron_tree.tree_provider.container_aware');
    
        if (! $provider->has($name)) {
            throw new \InvalidArgumentException(sprintf('The tree %s is not defined', $name));
        }
    
        $tree = $provider->get($name);
    
        return $tree;
    }
    
    private function getNodes(TreeInterface $tree, $nodeId = null)
    {
        $manager = $tree->getManager();
        
        $class = $tree->getDataClass();
        
        if (!class_exists($class)){
            throw new \InvalidArgumentException(sprintf('Class "%s" does not exist', $class));
        }
        
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository($class);
        $data = array();
        
        if ($nodeId === 0){
            $roots = $repo->getRootNodes();
            
            if (count($roots) == 0){
                $entity = new $class;
                $entity->setTitle($tree->getRootName());
                $entity->setSlug($tree->getRootName());
                $em->persist($entity);
                $em->flush($entity);
                
                $node = $entity;
                
            } else {
                $node = $roots[0];
            }
            
            $isLeaf = ($repo->childCount($node, true) > 0) ? true : false;
            $isRoot = $manager->isRoot($node);
            
            $class = '';
            
            if ($isRoot){
                $class .= 'tree-root ';
            }
            
            if ($isLeaf){
                $class .= 'jstree-leaf ';
            }
            
            $data[] = array(
                'data' => array(
                    'title' => $node->getTitle(),
                    'attr' => array('id' => 'node_' . $node->getId()),
                    'icon' => 'folder',
                ),
                'attr' => array('id' => 'li_' . $node->getId(), 'class' => $class),
                'metadata' => array(),
                'state' => $isLeaf ? 'open' : 'closed',
                'children' => $this->getNodes($tree, $node->getId())
            );
            
            return $data;
            
        } 
        
        $node = $repo->findOneById($nodeId);
        
        $children = $repo->children($node, true);
        
        foreach ($children as $child){
            $isLeaf = ($repo->childCount($child, true) > 0) ? true : false;
            
            $data[] = array(
                'data' => array(
                    'title' => $child->getTitle(),
                    'attr' => array('id' => 'node_' . $child->getId()),
                    'icon' => 'folder',
                ),
                'attr' => array('id' => 'li_' . $child->getId(), 'class' => $isLeaf ? '' : 'jstree-leaf'),
                'metadata' => array(),
                'state' => $isLeaf ? 'closed' : 'open',
          
            );
        }
        
        return $data;
    }
}
