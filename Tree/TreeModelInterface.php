<?php
namespace Neutron\TreeBundle\Tree;

interface TreeModelInterface
{
    public function getId();
    
    public function setTitle($title);
    
    public function getTitle();
    
    public function setSlug($slug);
    
    public function getSlug();
    
    public function setParent(TreeModelInterface $parent = null);
    
    public function getParent();
}