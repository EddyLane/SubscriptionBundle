<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 22/01/2014
 * Time: 21:32
 */

abstract class AbstractBaseManagerTest extends PHPUnit_Framework_TestCase
{
    protected $baseManager;

    protected function getGenericRepositoryMock()
    {
        return $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock()
            ;
    }

    protected function getDoctrineRegistryMock()
    {
        return $this->getMockBuilder('Doctrine\Bundle\DoctrineBundle\Registry')
            ->disableOriginalConstructor()
            ->getMock()
            ;
    }

    protected function getDoctrineManagerMock()
    {
        return $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock()
            ;
    }

} 