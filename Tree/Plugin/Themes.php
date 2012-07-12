<?php
namespace Neutron\TreeBundle\Tree\Plugin;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\OptionsResolver\Options;

class Themes  implements PluginInterface
{

    
    public function getName()
    {
        return 'themes';
    }
    
    public function getOptions()
    {
        return array();
    }
    

       
}