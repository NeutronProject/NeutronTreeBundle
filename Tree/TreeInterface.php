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
     * Sets data class
     * Must implement \Neutron\TreeBundle\Tree\NodeInterface
     * 
     * Provides a fluent interface
     * 
     * @param string $class
     * @return \Neutron\TreeBundle\Tree\TreeInterface
     */
    public function setDataClass($class);
    
    /**
     * Gets data class
     * 
     * @throws \LogicException
     * @return string
     */
    public function getDataClass();
    
    /**
     * Sets jsTree plugins
     * 
     * Provides a fluent interface
     * 
     * @param array $plugins
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
     * Sets root name
     * 
     * Provides a fluent interface
     * 
     * @param string $name
     * @return \Neutron\TreeBundle\Tree\TreeInterface
     */
    public function setRootName($name);
    
    /**
     * Gets root name
     * 
     * @return string
     */
    public function getRootName();
    
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