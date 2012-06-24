<?php
/*
 * This file is part of NeutronTreeBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\TreeBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Default implementation of CompilerPassInterface
 *
 * @author Nikolay Georgiev <azazen09@gmail.com>
 * @since 1.0
 */
class TreeCompilerPass implements CompilerPassInterface
{
    public function process (ContainerBuilder $container)
    {
        if (!$container->hasDefinition('neutron_tree.tree_provider.container_aware')) {
            return;
        }
                
        $definition = $container->getDefinition('neutron_tree.tree_provider.container_aware');
        
        $trees = array();
        
        foreach ($container->findTaggedServiceIds('neutron_tree.tree') as $id => $tags) {
            foreach ($tags as $attributes) {
                if (empty($attributes['alias'])) {
                    throw new \InvalidArgumentException(
                        sprintf('The alias is not defined in the "neutron_tree.tree" tag for the service "%s"', $id)
                    );
                }
                
                $trees[$attributes['alias']] = $id;
            }
        }
        
        $definition->replaceArgument(1, $trees);
    }
}
