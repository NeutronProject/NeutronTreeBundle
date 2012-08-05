<?php
namespace Neutron\TreeBundle\Model;

use Doctrine\ORM\EntityManager;

class TreeManagerFactory implements TreeManagerFactoryInterface
{
    protected $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getManagerForClass($class)
    {
        return new TreeManager($this->em, $class);
    }
}