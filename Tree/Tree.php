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
use Neutron\TreeBundle\Model\TreeManagerInterface;

use Gedmo\Exception\InvalidArgumentException;

use Neutron\TreeBundle\Tree\Plugin\PluginInterface;

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
     * @var \Neutron\TreeBundle\Model\TreeManagerInterface
     */
    protected $manager;
    
    /**
     * @var array<PluginInterface>
     */
    protected $plugins = array();
    
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
     * @see Neutron\TreeBundle\Tree.TreeInterface::setManager()
     */
    public function setManager(TreeManagerInterface $manager)
    {
        $this->manager = $manager;
        
        return $this;
    }
    
    public function getManager()
    {
        return $this->manager;
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::hasPlugin()
     */
    public function hasPlugin($name)
    {
        return isset($this->plugins[$name]);
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::addPlugin()
     */
    public function addPlugin(PluginInterface $plugin)
    {   
        if ($this->hasPlugin($plugin->getName())){ 
            throw new \InvalidArgumentException(
                sprintf('Tree plugin: "%s" already exists in the stack', $plugin->getName())
            );
        }
        
        $this->plugins[$plugin->getName()] = $plugin;
        
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::setPlugins()
     */
    public function setPlugins(array $plugins)
    {
        foreach ($plugins as $plugin){
            $this->addPlugin($plugin);
        }
        
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::getPlugin()
     */
    public function getPlugin($name)
    {
        if (!$this->hasPlugin($name)){
            throw new \InvalidArgumentException(
                sprintf('Tree plugin: "%s" does not exist in the stack', $name)
            );
        }
        
        return $this->plugins[$name];
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::getPlugins()
     */
    public function getPlugins()
    {
        return $this->plugins;
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::getPluginNames()
     */
    public function getPluginNames()
    {
        $pluginNames = array();
        
        array_map(function(PluginInterface $plugin) use (&$pluginNames){
            $pluginNames[] = $plugin->getName();
        }, $this->getPlugins());
        
        return $pluginNames;
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::getPluginsOptions()
     */
    public function getPluginsOptions()
    {
        $options = array();
        
        array_map(function(PluginInterface $plugin) use (&$options){
            $options[$plugin->getName()] = $plugin->getOptions();
        }, $this->getPlugins());
        
        return $options;
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::removePlugin()
     */
    public function removePlugin($name)
    {
        unset($this->plugins[name]);
        
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.TreeInterface::clearPlugins()
     */
    public function clearPlugins()
    {
        $this->plugins = array();
        
        return $this;
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
        $data['enabledPlugins'] = $this->getPluginNames();
        $data['plugins'] = $this->getPluginsOptions();
        $data['progressiveRender'] = $this->isProgressiveRenderEnabled();
        $data['progressiveUnload'] = $this->isProgressiveUnloadEnabled();
        
        return $data;
    }

}