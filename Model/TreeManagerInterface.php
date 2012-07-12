<?php
namespace Neutron\TreeBundle\Model;

use Neutron\TreeBundle\Model\TreeNodeInterface;

interface TreeManagerInterface
{
    public function isRoot(TreeNodeInterface $node);
    
    public function isLeaf(TreeNodeInterface $node);
    
    public function getRoot();
    
    public function getChildren(TreeNodeInterface $node);
    
    public function createNode();
    
    public function persistNode(TreeNodeInterface $node);
    
    public function findNodeBy(array $filter);
    
    public function updateNode(TreeNodeInterface $node);
    
    public function deleteNode(TreeNodeInterface $node);
    
    public function removeNodeFromTree(TreeNodeInterface $node);
    
    public function persistAsFirstChildOf(TreeNodeInterface $node, TreeNodeInterface $parent);
    
    public function persistAsLastChildOf(TreeNodeInterface $node, TreeNodeInterface $parent);
    
    public function persistAsPrevSiblingOf(TreeNodeInterface $node, TreeNodeInterface $sibling);
    
    public function persistAsNextSiblingOf(TreeNodeInterface $node, TreeNodeInterface $sibling);
    

}