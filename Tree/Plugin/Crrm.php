<?php
namespace Neutron\TreeBundle\Tree\Plugin;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\OptionsResolver\Options;

class Crrm  implements PluginInterface
{

    
    public function getName()
    {
        return 'crrm';
    }
    
    public function getOptions()
    {
        return array();
    }
    

       
}