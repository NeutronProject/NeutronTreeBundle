<?php
/*
 * This file is part of NeutronTreeBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\TreeBundle\Tree;

use Doctrine\ORM\EntityManager;

use Neutron\TreeBundle\Model\TreeManager;

use Symfony\Component\HttpFoundation\Request;

use Neutron\Bundle\AsseticBundle\Controller\AsseticController;

/**
 * Factory to create a tree
 *
 * @author Nikolay Georgiev <nikolay.georgiev@zend.bg>
 * @since 1.0
 */
class TreeFactory implements FactoryInterface
{

    /**
     * @var EntityManager
     */
    protected $em;
    
    /**
     * @var \Neutron\Bundle\AsseticBundle\Controller\AsseticController
     */
    protected $neutronAssetic;
    
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;
    
    /**
     * @var string
     */
    protected $path;
    
    /**
     * Construct
     *
     * @param AsseticController $neutronAssetic
     * @param Request $request
     * @param string $path
     */
    public function __construct(EntityManager $em, AsseticController $neutronAssetic, Request $request, $path)
    {
        $this->em = $em;
        $this->neutronAssetic = $neutronAssetic;
        $this->request = $request;
        $this->path = $path;
    }
    
    /**
     * (non-PHPdoc)
     *
     * @see Neutron\Bundle\DataGridBundle\DataGrid.FactoryInterface::createDataGrid()
     */
    public function createTree ($name, array $options = array())
    {
        
        $this->neutronAssetic->appendJavascript($this->path . '/jquery.jstree.js');
        $this->neutronAssetic->appendJavascript('bundles/neutrontree/js/init.js');
        
        $tree = new Tree($name);
        
        /* merging options */
        $options = array_merge(
            array(
                'name' => null, 
                'dataClass' => null,
                'plugins' => array(),
            ), $options
        );
        
        /* setting object */
        $tree
            ->setDataClass($options['dataClass'])
            ->setPlugins($options['plugins'])
            
        ;
        
        return $tree;
    }

    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.FactoryInterface::createTreeFromArray()
     */
    public function createTreeFromArray (Array $data)
    {
        $name = isset($data['name']) ? $data['name'] : $name;
        
        return $this->createTree($name);
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.FactoryInterface::createPlugin()
     */
    public function createPlugin($plugin, array $options = array())
    {
    
        switch (strtolower($plugin)){
            case 'ui':
                $plugin = '\Neutron\TreeBundle\Tree\Plugin\UI';
                break;
            case 'contextmenu':
                $plugin = '\Neutron\TreeBundle\Tree\Plugin\ContextMenu';
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Invalid plugin "%s"!',  $plugin));
        }
    
        return new $plugin($options);
    }
    
    /**
     * (non-PHPdoc)
     * @see Neutron\TreeBundle\Tree.FactoryInterface::createManager()
     */
    public function createManager($class)
    {
        $manager = new TreeManager($this->em, $class);
        
        return $manager;
    }
}