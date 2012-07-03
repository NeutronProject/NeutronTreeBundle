<?php
namespace Neutron\TreeBundle\Tree\Plugin;

class UI implements PluginInterface 
{
    protected $selectLimit = -1;

    public function setSelectLimit($limit)
    {
        $this->selectLimit = (int) $limit;
    }
    
    public function getSelectLimit()
    {
        return $this->selectLimit;
    }
    
    public function getName()
    {
        return 'ui';
    }
    
    public function getOptions()
    {
        return array(
            'select_limit' => $this->getSelectLimit()        
        );
    }
       
}