<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 25/01/2014
 * Time: 16:00
 */

class SubscriptionListenerTest extends AbstractListenerTest
{
    protected $operationFactorySpy;

    protected function getSubject($enabled = true)
    {
        $this->operationFactorySpy = $this->getMockBuilder('Fridge\SubscriptionBundle\Factory\OperationFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $subject = new Fridge\SubscriptionBundle\EventListener\SubscriptionListener(
            $this->operationFactorySpy,
            $enabled
        );

        $subject->setEntityClass('Fridge\SubscriptionBundle\Model\Subscription');

        return $subject;
    }


    public function testPostPersistSavesSubscription()
    {
        $subject = $this->getSubject();

        $profileEntity = new Fridge\SubscriptionBundle\Entity\Subscription();

        $eventArgs = $this->getEventArgs('Fridge\SubscriptionBundle\Entity\Subscription');

        $eventArgs->expects($this->atLeastOnce())
            ->method('getEntity')
            ->will($this->returnValue($profileEntity));

        $subscriptionUpdateOperation = $this->getMockBuilder('Fridge\SubscriptionBundle\Operation\CreatePlanOperation')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->operationFactorySpy->expects($this->once())
            ->method('get')
            ->with('plan.create')
            ->will($this->returnValue($subscriptionUpdateOperation))
        ;

        $subscriptionUpdateOperation->expects($this->once())
            ->method('getResult')
            ->with($profileEntity)
       ;

        $subject->postPersist($eventArgs);
    }


    public function testPreRemoveRemovesSubscription()
    {
        $subject = $this->getSubject();

        $profileEntity = new Fridge\SubscriptionBundle\Entity\Subscription();

        $eventArgs = $this->getEventArgs('Fridge\SubscriptionBundle\Entity\Subscription');

        $eventArgs->expects($this->atLeastOnce())
            ->method('getEntity')
            ->will($this->returnValue($profileEntity));

        $subscriptionUpdateOperation = $this->getMockBuilder('Fridge\SubscriptionBundle\Operation\RemovePlanOperation')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->operationFactorySpy->expects($this->once())
            ->method('get')
            ->with('plan.remove')
            ->will($this->returnValue($subscriptionUpdateOperation))
        ;

        $subscriptionUpdateOperation->expects($this->once())
            ->method('getResult')
            ->with($profileEntity)
        ;

        $subject->preRemove($eventArgs);
    }
} 