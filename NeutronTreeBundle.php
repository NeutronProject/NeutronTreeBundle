<?php
namespace Neutron\TreeBundle;

use Neutron\TreeBundle\DependencyInjection\Compiler\TreeCompilerPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NeutronTreeBundle extends Bundle
{
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\HttpKernel\Bundle.Bundle::build()
     */
    public function build (ContainerBuilder $container)
    {
        parent::build($container);
    
        $container->addCompilerPass(new TreeCompilerPass());
    }
}
