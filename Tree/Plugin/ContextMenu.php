<?php
namespace Neutron\TreeBundle\Tree\Plugin;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\OptionsResolver\Options;

class ContextMenu  implements PluginInterface
{
    protected $createBtnOptions;
    
    public function __construct(array $options)
    {
        isset($options['createBtnOptions']) ? $this->setCreateBtnOptions($options['createBtnOptions']) : 
            $this->setCreateBtnOptions(array());
    }
    
    public function setCreateBtnOptions(array $options)
    {
        $resolver = new OptionsResolver();
        
        $resolver->setDefaults(array(
            'disabled' => true,
            'label'     => 'Create',
       ));
        
        $resolver->setAllowedTypes(array(
            'disabled' => array('bool'),
            'label'     => array('string'),
        ));
        
        $resolver->setRequired(array('uri'));
        
        $this->createBtnOptions = $resolver->resolve($options);
        
        return $this;
    }
    
    public function getCreateBtnOptions()
    {
        return $this->createBtnOptions;
    }

    public function getName()
    {
        return 'contextmenu';
    }
    
    public function getOptions()
    {
        return array(
            'createBtnOptions' => $this->getCreateBtnOptions(),
        );
    }
       
}