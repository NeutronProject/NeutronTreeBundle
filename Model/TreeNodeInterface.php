<?php
namespace Neutron\TreeBundle\Model;

interface TreeNodeInterface
{
    public function getId();
    
    public function setTitle($title);
    
    public function getTitle();
    
    public function setType($type);
    
    public function getType();
    
    public function getLevel();
    
    public function getParent();
}