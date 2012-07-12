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
 * Interface implemented by a Tree class.
 *
 * This interace defines all options for jsTree
 *
 * @author Nikolay Georgiev <azazen09@gmail.com>
 * @since 1.0
 */

use Neutron\TreeBundle\Model\TreeManagerInterface;

use Neutron\TreeBundle\Tree\Plugin\PluginInterface;

interface TreeInterface
{
    /**
     * Set name of tree. 
     * Must be unique!
     *
     * Provides a fluent interface
     *
     * @param string $name
     * @return \Neutron\TreeBundle\Tree\TreeInterface
     */
    public function setName($name);
    
    /**
     * Gets name of the tree
     * 
     * @return string
     */
    public function getName();

    /**
     * Sets tree manager
     * 
     * Provide fluent interface
     * 
     * @param TreeManagerInterface $manager
     * @return \Neutron\TreeBundle\Tree\TreeInterface
     */
    public function setManager(TreeManagerInterface $manager);
    
    /**
     * Gets Tree manager.
     * Object responsible for persisting nodes to storage.
     * 
     * @return \Neutron\TreeBundle\Model\TreeMananerInterface
     */
    public function getManager();
    
    /**
     * Adds tree plugin
     * 
     * Provides a fluent interface
     * 
     * @param PluginInterface $plugin
     * @return \Neutron\TreeBundle\Tree\TreeInterface
     */
    public function addPlugin(PluginInterface $plugin);
    
    /**
     * Gets tree plugin
     * 
     * @param string $name
     * @return \Neutron\TreeBundle\Tree\Plugin\PluginInterface
     * @throws \InvalidArgumentException
     */
    public function getPlugin($name);
    
    /**
     * Checks if tree plugin exists
     * 
     * @param string $name
     * @return boolean
     */
    public function hasPlugin($name);
    
    
    /**
     * Sets jsTree plugins
     * 
     * Provides a fluent interface
     * 
     * @param array<PluginInterface> $plugins
     * @return \Neutron\TreeBundle\Tree\TreeInterface
     */
    public function setPlugins(array $plugins);
    
    /**
     * Gets jsTree plugins
     * 
     * @return array
     */
    public function getPlugins();
    
    /**
     * Gets name of tree pluguns
     * 
     * @return array<string>
     */
    public function getPluginNames();
    
    /**
     * Converts all plugins in the stack to array
     * 
     * @return array
     */
    public function getPluginsOptions();
    
    
    /**
     * Removes tree plugin from the stack
     * 
     * Provides a fluent interface
     * 
     * @param string $name
     * @return \Neutron\TreeBundle\Tree\TreeInterface
     */
    public function removePlugin($name);
    
    /**
     * Clears all tree plugins
     * 
     * Provides a fluent interface
     * 
     * @return \Neutron\TreeBundle\Tree\TreeInterface
     */
    public function clearPlugins();
    
    /**
     * Enables jstree option progressive_render
     * Default is set to false
     * 
     * Provides a fluent interface
     * 
     * @param boolean $bool
     * @return \Neutron\TreeBundle\Tree\TreeInterface
     */
    public function enableProgressiveRender($bool);
    
    /**
     * Returns if progressive_render is enabled
     * 
     * @return boolean
     */
    public function isProgressiveRenderEnabled();
    
    /**
     * Enables jstree option progressive_unload
     * Default is set to false
     * 
     * Provides a fluent interface
     * 
     * @param boolean $bool
     * @return \Neutron\TreeBundle\Tree\TreeInterface
     */
    public function enableProgressiveUnload($bool);
    
    /**
     * Returns if progressive_unload is enabled
     * 
     * @return boolean
     */
    public function isProgressiveUnloadEnabled();
  
}