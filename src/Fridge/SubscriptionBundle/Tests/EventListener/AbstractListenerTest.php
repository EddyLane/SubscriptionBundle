<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 25/01/2014
 * Time: 17:36
 */

abstract class AbstractListenerTest extends PHPUnit_Framework_TestCase
{

    protected function getEventArgs($className, $updateArgs = false)
    {
        if($updateArgs) {

            $eventArgs = $this->getMockBuilder('Doctrine\ORM\Event\PreUpdateEventArgs')
                ->disableOriginalConstructor()
                ->getMock()
            ;
        } else {
            $eventArgs = $this->getMockBuilder('Doctrine\ORM\Event\LifecycleEventArgs')
                ->disableOriginalConstructor()
                ->getMock()
            ;
        }

        $em = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $eventArgs->expects($this->once())
            ->method('getEntityManager')
            ->will($this->returnValue($em));

        $metaData = $this->getMockBuilder('Doctrine\ORM\Mapping\ClassMetadata')
            ->disableOriginalConstructor()
            ->getMock();

        $metaData->expects($this->atLeastOnce())
            ->method('getName')
            ->will($this->returnValue($className));

        $em->expects($this->atLeastOnce())
            ->method('getClassMetadata')
            ->with($className)
            ->will($this->returnValue($metaData));

        return $eventArgs;
    }



} 