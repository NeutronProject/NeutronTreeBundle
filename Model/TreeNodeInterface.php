<?php
namespace Neutron\TreeBundle\Model;

interface TreeNodeInterface
{
    public function getId();
    
    public function setTitle($title);
    
    public function getTitle();
    
    public function setSlug($slug);
    
    public function getSlug();
    
    public function setLinkTarget($target);
    
    public function getLinkTarget();
    
    public function setType($type);
    
    public function getType();
    
    public function setEnabled($bool);
  
    public function isEnabled();
    
    public function setDisplayed($bool);
    
    public function isDisplayed();
    
    public function setParent(TreeNodeInterface $parent = null);
    
    public function getParent();
}