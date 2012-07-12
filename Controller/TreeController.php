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
        $manager = $tree->getManager();
        
        $nodeId = $this->getRequest()->get('nodeId', false);
        $refId = $this->getRequest()->get('refId', false);
        $operation = $this->getRequest()->get('operation', false);
        
        $node = $manager->findNodeBy(array('id' => $nodeId));
        
        $refNode = $manager->findNodeBy(array('id' => $refId));
        
        if (!$node || !$refNode){
            throw new \InvalidArgumentException('Node or RefNode is not found!');
        }
        
        $operations = array(
            'before' => 'persistAsPrevSiblingOf',
            'after'  => 'persistAsNextSiblingOf',
            'last'   => 'persistAsLastChildOf',
            'first'  => 'persistAsFirstChildOf'
        );
        
        if (!array_key_exists($operation, $operations)){
            throw new \InvalidArgumentException(sprintf('Operation "%s" is not allowed!',$operation));
        }
        
        $method = $operations[$operation];
        
        $manager->$method($node, $refNode);
        
        return new Response(json_encode(array('success' => true)));
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

        $data = array();
        
        if ($nodeId === 0){
            $node = $manager->getRoot();
            
            if (!$node){
                throw new \RuntimeException('Root node is not defined. Please use command neutron:admin:create-tree');
            } 
            
            $isLeaf = $manager->isLeaf($node);
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
                'attr' => array('id' => 'li_' . $node->getId(), 'class' => $class, 'rel' => $node->getType()),
                'metadata' => array(),
                'state' => $isLeaf ? 'open' : 'closed',
                'children' => $this->getNodes($tree, $node->getId())
            );
            
            return $data;
            
        } 
        
        $node = $manager->findNodeBy(array('id' => $nodeId));
        
        $children = $manager->getChildren($node);
        
        foreach ($children as $child){
            $isLeaf = $manager->isLeaf($child);
            
            $data[] = array(
                'data' => array(
                    'title' => $child->getTitle(),
                    'attr' => array('id' => 'node_' . $child->getId()),
                    'icon' => 'folder',
                ),
                'attr' => array('id' => 'li_' . $child->getId(), 'class' => $isLeaf ? '' : 'jstree-leaf', 'rel' => $child->getType()),
                'metadata' => array(),
                'state' => $isLeaf ? 'closed' : 'open',
          
            );
        }
        
        return $data;
    }
    

}
