<?php
namespace Neutron\TreeBundle\Tree\Plugin;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\OptionsResolver\Options;

class Cookies  implements PluginInterface
{

    
    public function getName()
    {
        return 'cookies';
    }
    
    public function getOptions()
    {
        return array();
    }
    

       
}