<?php
namespace Neutron\TreeBundle\Tree\Plugin;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\OptionsResolver\Options;

class ContextMenu  implements PluginInterface
{
    protected $createBtnOptions;
    
    protected $updateBtnOptions;
    
    protected $deleteBtnOptions;
    
    public function __construct(array $options)
    {
        isset($options['createBtnOptions']) ? $this->setCreateBtnOptions($options['createBtnOptions']) : 
            $this->setCreateBtnOptions(array());
        
        isset($options['updateBtnOptions']) ? $this->setUpdateBtnOptions($options['updateBtnOptions']) : 
            $this->setUpdateBtnOptions(array());
        
        isset($options['deleteBtnOptions']) ? $this->setDeleteBtnOptions($options['deleteBtnOptions']) : 
            $this->setDeleteBtnOptions(array());
    }
    
    public function setCreateBtnOptions(array $options)
    {        
        $this->createBtnOptions = $this->resolveOptions($options);
        
        return $this;
    }
    
    public function getCreateBtnOptions()
    {
        return $this->createBtnOptions;
    }
    
    public function setUpdateBtnOptions(array $options)
    {
        $this->updateBtnOptions = $this->resolveOptions($options);
        
        return $this;
    }
    
    public function getUpdateBtnOptions()
    {
        return $this->updateBtnOptions;
    }
    
    public function setDeleteBtnOptions(array $options)
    {
        $this->deleteBtnOptions = $this->resolveOptions($options);
        
        return $this;
    }
    
    public function getDeleteBtnOptions()
    {
        return $this->deleteBtnOptions;
    }

    public function getName()
    {
        return 'contextmenu';
    }
    
    public function getOptions()
    {
        return array(
            'createBtnOptions' => $this->getCreateBtnOptions(),
            'updateBtnOptions' => $this->getUpdateBtnOptions(),
            'deleteBtnOptions' => $this->getDeleteBtnOptions(),
        );
    }
    
    protected function resolveOptions(array $options)
    {
        $resolver = new OptionsResolver();
        
        $resolver->setDefaults(array(
            'disabled' => true,
            'label'     => 'Button',
        ));
        
        $resolver->setAllowedTypes(array(
            'disabled' => array('bool'),
            'label'     => array('string'),
        ));
        
        $resolver->setRequired(array('uri'));
        
        return $resolver->resolve($options);
    }
       
}