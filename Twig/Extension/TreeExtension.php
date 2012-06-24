<?php
/*
 * This file is part of NeutronTreeBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\TreeBundle\Twig\Extension;

use Neutron\TreeBundle\Tree\TreeInterface;

use Symfony\Component\DependencyInjection\Container;

/**
 * Twig Extension for rendering initial content of jstree
 *
 * @author Nikolay Georgiev <azazen09@gmail.com>
 * @since 1.0
 */
class TreeExtension extends \Twig_Extension
{

    /**
     * @var Container
     */
    protected $container;

    /**
     * Construct
     *
     * @param Container $container            
     */
    public function __construct (Container $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions ()
    {
        return 
            array(
                'neutron_tree' => new \Twig_Function_Method($this, 'renderTree', 
                     array('is_safe' => array('html'))
                )
            );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName ()
    {
        return 'neutron_tree';
    }

    /**
     * Rendering initial content of the jstree
     *
     * @param TreeInterface $tree      
     * @return string (html response)
     */
    public function renderTree (TreeInterface $tree)
    {
         return 
            $this->container->get('templating')->render(
                'NeutronTreeBundle:Tree:index.html.twig', 
                array('tree' => $tree)
             );
    }

}
