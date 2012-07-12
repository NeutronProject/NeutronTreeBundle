<?php
namespace Neutron\TreeBundle\Tree\Plugin;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\OptionsResolver\Options;

class Types  implements PluginInterface
{

    protected $types = array();
    
    public function __construct(array $options)
    {
        $this->set($options);
    }
    
    public function has($name)
    {
        return isset($this->types[$name]);
    }
    
    public function add(array $options)
    {
        $options = $this->resolveTypeOptions($options);
        $name = $options['name'];
        unset($options['name']);
        unset($options['children_strategy']);
        
        if (!$this->has($name)){
            $this->types[$name] = $options;
        }
        
        return $this;
    }
    
    public function set(array $types)
    {
        foreach ($types as $options){
            $this->add($options);
        }
        
        return $this;
    }
    
    public function get($name)
    {
        if (!$this->has($name)){
            throw new \InvalidArgumentException(
                sprintf('Type with name "%s" is not in the stack!', $name)
            );
        }
        
        return $this->types[$name];
    }
    
    public function all()
    {
        return $this->types;
    }
    
    public function remove($name)
    {
        if (!$this->has($name)){
            throw new \InvalidArgumentException(
                sprintf('Type with name "%s" is not in the stack!', $name)
            );
        }
        
        unset($this->types[$name]);
        
        return $this;
    }
    
    public function clear()
    {
        $this->types = array();
        
        return $this;
    }
    
    public function getName()
    {
        return 'types';
    }
    
    public function getOptions()
    {
        return $this->all();
    }
    
    protected function resolveTypeOptions(array $options)
    {
        $resolver = new OptionsResolver();
        
        $resolver->setDefaults(array(
            'children_strategy' => 'none',
            'valid_children' => function(Options $options){
                $strategy = null;
                switch ($options->get('children_strategy')){
                    case 'none':
                        $strategy = 'none';
                        break;
                    case 'all':
                        $strategy = 'all';
                        break;
                    case 'self':
                        $strategy = array($options->get('name'));
                        break;
                    default:
                        $strategy = 'none';
                }
                
                return $strategy;
            },
            'start_drag' => true,
            'move_node' => true,
            'select_node' => true,
            'hover_node' => true,
            'disable_create_btn' => true,
            'disable_update_btn' => true,
            'disable_delete_btn' => true,
        ));
            
        $resolver->setRequired(array(
            'name'        
        ));
        
        $resolver->setAllowedValues(array(
            'children_strategy' => array('all', 'none', 'self'),        
        ));
        
        $resolver->setAllowedTypes(array(
            'name' => 'string',
            'children_strategy' => 'string',
            'start_drag' => 'bool',
            'move_node' => 'bool',
            'select_node' => 'bool',
            'hover_node' => 'bool',
            'disable_create_btn' => 'bool',
            'disable_update_btn' => 'bool',
            'disable_delete_btn' => 'bool',
        ));
        
        return $resolver->resolve($options);
    }

       
}