<?php
namespace Neutron\TreeBundle\Tree\Plugin;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\OptionsResolver\Options;

class Dnd  implements PluginInterface
{

    
    public function getName()
    {
        return 'dnd';
    }
    
    public function getOptions()
    {
        return array();
    }
    

       
}