<?php

/*
 * This file is part of NeutronTreeBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Neutron\TreeBundle\Tree;


/**
 * Default implementation of the TreeInterface
 *
 * @author Nikolay Georgiev <azazen09@gmail.com>
 * @since 1.0
 */
class Tree implements TreeInterface
{
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $dataClass;
    
    /**
     * @var array<string>
     */
    protected $plugins;
    
    /**
     * @var string
     */
    protected $rootName = 'Root';
    
    /**
     * @var boolean
     */
    protected $progressiveRender = false;
    
    /**
     * @var boolean
     */
    protected $progressiveUnload = false;
    
    /**
     * Construct
     * 
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::setName()
     */
    public function setName($name)
    {
        $this->name = (string) $name;
        
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::getName()
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::setDataClass()
     */
    public function setDataClass($class)
    {
        $this->dataClass = (string) $class;
        
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::getDataClass()
     */
    public function getDataClass()
    {
        if (null === $this->dataClass){
            throw new \LogicException('Option:dataClass is not set!');
        }
        
        return $this->dataClass;
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::setPlugins()
     */
    public function setPlugins(array $plugins)
    {
        $this->plugins = $plugins;
        
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::getPlugins()
     */
    public function getPlugins()
    {
        $defaultPlugins = array('themes', 'json_data', 'ui');
        $plugins = array_merge($defaultPlugins, $this->plugins);
        
        return array_unique($plugins);
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::setRootName()
     */
    public function setRootName($name)
    {
        $this->rootName = (string) $name;
        
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::getRootName()
     */
    public function getRootName()
    {
        return $this->rootName;
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::enableProgressiveRender()
     */
    public function enableProgressiveRender($bool)
    {
        $this->progressiveRender = (bool) $bool;
        
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::isProgressiveRenderEnabled()
     */
    public function isProgressiveRenderEnabled()
    {
        return $this->progressiveRender;
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::enableProgressiveUnload()
     */
    public function enableProgressiveUnload($bool)
    {
        $this->progressiveUnload = (bool) $bool;
        
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::isProgressiveUnloadEnabled()
     */
    public function isProgressiveUnloadEnabled()
    {
        return $this->progressiveUnload;
    }
    
    /**
     * Exports tree options to array
     * 
     * @return array
     */
    public function toArray()
    {
        $data['name'] = $this->getName();
        $data['plugins'] = $this->getPlugins();
        $data['progressiveRender'] = $this->isProgressiveRenderEnabled();
        $data['progressiveUnload'] = $this->isProgressiveUnloadEnabled();
        
        return $data;
    }

}