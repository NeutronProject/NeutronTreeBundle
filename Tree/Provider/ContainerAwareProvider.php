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

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Default implementation of the TreeProviderInterface
 *
 * @author Nikolay Georgiev <azazen09@gmail.com>
 * @since 1.0
 */
class ContainerAwareProvider implements TreeProviderInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var TreeInterface[]
     */
    private $treeIds;

    /**
     * Construct
     *
     * @param ContainerInterface $container            
     * @param array $treeIds            
     */
    public function __construct (ContainerInterface $container, array $treeIds = array())
    {
        $this->container = $container;
        $this->treeIds = $treeIds;
    }

    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree\Provider.TreeProviderInterface::get()
     */
    public function get ($name)
    {
        if (! isset($this->treeIds[$name])) {
            throw new \InvalidArgumentException(sprintf('The tree "%s" is not defined.', $name));
        }
        
        return $this->container->get($this->treeIds[$name]);
    }

    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree\Provider.TreeProviderInterface::has()
     */
    public function has ($name)
    {
        return isset($this->treeIds[$name]);
    }

}