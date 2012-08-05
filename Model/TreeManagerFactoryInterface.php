<?php
namespace Neutron\TreeBundle\Model;

interface TreeManagerFactoryInterface
{
    public function getManagerForClass($class);
}