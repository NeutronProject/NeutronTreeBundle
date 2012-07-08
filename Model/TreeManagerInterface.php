<?php
namespace Neutron\TreeBundle\Model;

use Neutron\TreeBundle\Tree\TreeModelInterface;

interface TreeManagerInterface
{
    public function isRoot(TreeModelInterface $node);
    
    public function createNode();
    
    public function findNodeBy(array $filter);
    
    public function updateNode(TreeModelInterface $node);
    
    public function deleteNode(TreeModelInterface $node);
    
    public function persistAsFirstChildOf(TreeModelInterface $node, TreeModelInterface $parent);
    
    public function persistAsLastChildOf(TreeModelInterface $node, TreeModelInterface $parent);
}