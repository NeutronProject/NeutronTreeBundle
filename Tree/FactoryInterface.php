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
 * Interface implemented by the factory to create jsTree
 *
 * @author Nikolay Georgiev <azazen09@gmail.com>
 * @since 1.0
 */
interface FactoryInterface
{

    /**
     * Create a tree from TreeInterface
     *
     * @param string $name;            
     * @param Array $options            
     * @return \Neutron\TreeBundle\Tree\TreeInterface
     */
    public function createTree ($name, array $options = array());
    
    /**
     * Create a tree from array
     * The source is an array of data that should match the output from
     * $tree->toArray()
     *
     * @param array $data
     * @return \Neutron\TreeBundle\Tree\TreeInterface
     */
    public function createTreeFromArray (array $data);
    
    /**
     * Creates new instance of tree plugin
     *
     *
     * @param string $plugin
     * @return \Neutron\TreeBundle\Tree\Plugin\PluginInterface
     * @throws \InvalidArgumentException
     */
    public function createPlugin($plugin);

}