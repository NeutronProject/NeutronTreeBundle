<?php

namespace Neutron\TreeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('neutron_tree');

        $this->addPathConfiguration($rootNode);

        return $treeBuilder;
    }
    
    
    private function addPathConfiguration(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->scalarNode('path_to_jstree')->isRequired(true)->end()
            ->end()
        ;
    }
}
