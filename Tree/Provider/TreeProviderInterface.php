<?php
/*
 * This file is part of NeutronTreeBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\TreeBundle\Tree\Provider;

/**
 * Interface implemented by a ContainerAwareProvider class.
 *
 * @author Nikolay Georgiev <azazen09@gmail.com>
 * @since 1.0
 */
interface TreeProviderInterface
{

    /**
     * Retrieves a tree by its name
     *
     * @param string $name            
     * @return \Neutron\TreeBundle\Tree\TreeInterface
     * @throws \InvalidArgumentException if the tree does not exists
     */
    function get ($name);

    /**
     * Checks whether a tree exists in this provider
     *
     * @param string $name            
     * @return bool
     */
    function has ($name);
}
