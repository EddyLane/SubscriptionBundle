<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 24/01/2014
 * Time: 00:04
 */

use Fridge\SubscriptionBundle\EventListener\AbstractEntityEventListener;

class AbstractEntityEventListenerTest extends PHPUnit_Framework_TestCase
{

    protected function getSubject($enabled = true)
    {
        return $this->getMockForAbstractClass('Fridge\SubscriptionBundle\EventListener\AbstractEntityEventListener', [
            $this->getMockBuilder('Fridge\SubscriptionBundle\Factory\OperationFactory')->disableOriginalConstructor()->getMock(),
            $enabled
        ]);
    }

    public function testNotEnabled()
    {
        $subject = $this->getSubject(false);
        $subject->setSubscribedEvents(['prePersist', 'postPersist']);
        $this->assertEmpty($subject->getSubscribedEvents());
    }

    public function testIsEnabled()
    {
        $subject = $this->getSubject(true);
        $subject->setSubscribedEvents(['prePersist', 'postPersist']);
        $this->assertEquals(['prePersist', 'postPersist'], $subject->getSubscribedEvents());
    }

    public function testMatchesEntityClassSubclassFunctionality()
    {
        $subject = $this->getSubject(false);
        $subject->setEntityClass('Fridge\SubscriptionBundle\Model\Card');

        $eventArgs = $this->getMockBuilder('Doctrine\ORM\Event\LifecycleEventArgs')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $eventArgs->expects($this->once())
            ->method('getEntity')
            ->will($this->returnValue(new Fridge\SubscriptionBundle\Entity\Card()));

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
            ->will($this->returnValue('Fridge\SubscriptionBundle\Entity\Card'));

        $em->expects($this->atLeastOnce())
            ->method('getClassMetadata')
            ->with('Fridge\SubscriptionBundle\Entity\Card')
            ->will($this->returnValue($metaData));

        $this->assertTrue($subject->matchesEntityClass($eventArgs));
    }

    public function testMatchesEntityClassExactlysFunctionality()
    {
        $subject = $this->getSubject(false);
        $subject->setEntityClass('Fridge\SubscriptionBundle\Entity\Subscription');

        $eventArgs = $this->getMockBuilder('Doctrine\ORM\Event\LifecycleEventArgs')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $eventArgs->expects($this->once())
            ->method('getEntity')
            ->will($this->returnValue(new Fridge\SubscriptionBundle\Entity\Subscription()));

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
            ->will($this->returnValue('Fridge\SubscriptionBundle\Entity\Subscription'));

        $em->expects($this->atLeastOnce())
            ->method('getClassMetadata')
            ->with('Fridge\SubscriptionBundle\Entity\Subscription')
            ->will($this->returnValue($metaData));

        $this->assertTrue($subject->matchesEntityClass($eventArgs));
    }

    public function testNotMatchesClassFunctionality()
    {
        $subject = $this->getSubject(false);
        $subject->setEntityClass('Fridge\SubscriptionBundle\Model\Card');

        $eventArgs = $this->getMockBuilder('Doctrine\ORM\Event\LifecycleEventArgs')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $eventArgs->expects($this->once())
            ->method('getEntity')
            ->will($this->returnValue(new Fridge\SubscriptionBundle\Entity\StripeProfile()));

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
            ->will($this->returnValue('Fridge\SubscriptionBundle\Entity\StripeProfile'));

        $em->expects($this->atLeastOnce())
            ->method('getClassMetadata')
            ->with('Fridge\SubscriptionBundle\Entity\StripeProfile')
            ->will($this->returnValue($metaData));

        $this->assertFalse($subject->matchesEntityClass($eventArgs));
    }



} 