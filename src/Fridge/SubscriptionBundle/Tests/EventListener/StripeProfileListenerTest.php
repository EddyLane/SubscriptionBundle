<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 25/01/2014
 * Time: 16:00
 */

class StripeProfileListenerTest extends AbstractListenerTest
{
    protected $operationFactorySpy;

    protected function getSubject($enabled = true)
    {
        $this->operationFactorySpy = $this->getMockBuilder('Fridge\SubscriptionBundle\Factory\OperationFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $subject = new Fridge\SubscriptionBundle\EventListener\StripeProfileListener(
            $this->operationFactorySpy,
            $enabled
        );

        $subject->setEntityClass('Fridge\SubscriptionBundle\Model\StripeProfile');

        return $subject;
    }

    /*
     * Pre Update
     */

    public function testPreUpdateUpdatesSubscriptionWhenChanged()
    {
        $subject = $this->getSubject();

        $profileEntity = new Fridge\SubscriptionBundle\Entity\StripeProfile();
        $profileEntity->setSubscription(new Fridge\SubscriptionBundle\Entity\Subscription());


        $eventArgs = $this->getEventArgs('Fridge\SubscriptionBundle\Entity\StripeProfile', true);

        $eventArgs->expects($this->at(2))
            ->method('hasChangedField')
            ->with('subscription')
            ->will($this->returnValue(true));

        $eventArgs->expects($this->at(5))
            ->method('hasChangedField')
            ->with('defaultCard')
            ->will($this->returnValue(false));

        $eventArgs->expects($this->atLeastOnce())
            ->method('getEntity')
            ->will($this->returnValue($profileEntity));

        $subscriptionUpdateOperation = $this->getMockBuilder('Fridge\SubscriptionBundle\Operation\UpdateSubscriptionOperation')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->operationFactorySpy->expects($this->once())
            ->method('get')
            ->with('subscription.update')
            ->will($this->returnValue($subscriptionUpdateOperation))
        ;

        $subscriptionUpdateOperation->expects($this->once())
            ->method('getResult')
            ->with($profileEntity)
       ;

        $subject->preUpdate($eventArgs);
    }
    public function testPreUpdateRemovesSubscriptionWhenRemoved()
    {
        $subject = $this->getSubject();

        $profileEntity = new Fridge\SubscriptionBundle\Entity\StripeProfile();

        $eventArgs = $this->getEventArgs('Fridge\SubscriptionBundle\Entity\StripeProfile', true);

        $eventArgs->expects($this->at(2))
            ->method('hasChangedField')
            ->with('subscription')
            ->will($this->returnValue(true));

        $eventArgs->expects($this->at(5))
            ->method('hasChangedField')
            ->with('defaultCard')
            ->will($this->returnValue(false));

        $eventArgs->expects($this->atLeastOnce())
            ->method('getEntity')
            ->will($this->returnValue($profileEntity));

        $subscriptionUpdateOperation = $this->getMockBuilder('Fridge\SubscriptionBundle\Operation\UpdateSubscriptionOperation')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->operationFactorySpy->expects($this->once())
            ->method('get')
            ->with('subscription.remove')
            ->will($this->returnValue($subscriptionUpdateOperation))
        ;

        $subscriptionUpdateOperation->expects($this->once())
            ->method('getResult')
            ->with($profileEntity)
        ;

        $subject->preUpdate($eventArgs);
    }

    public function testPreUpdateUpdatesCardnWhenChanged()
    {
        $subject = $this->getSubject();

        $profileEntity = new Fridge\SubscriptionBundle\Entity\StripeProfile();
        $profileEntity->setSubscription(new Fridge\SubscriptionBundle\Entity\Subscription());


        $eventArgs = $this->getEventArgs('Fridge\SubscriptionBundle\Entity\StripeProfile', true);

        $eventArgs->expects($this->at(2))
            ->method('hasChangedField')
            ->with('subscription')
            ->will($this->returnValue(false));

        $eventArgs->expects($this->at(3))
            ->method('hasChangedField')
            ->with('defaultCard')
            ->will($this->returnValue(true));

        $eventArgs->expects($this->atLeastOnce())
            ->method('getEntity')
            ->will($this->returnValue($profileEntity));

        $subscriptionUpdateOperation = $this->getMockBuilder('Fridge\SubscriptionBundle\Operation\UpdateSubscriptionOperation')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->operationFactorySpy->expects($this->once())
            ->method('get')
            ->with('customer.update')
            ->will($this->returnValue($subscriptionUpdateOperation))
        ;

        $subscriptionUpdateOperation->expects($this->once())
            ->method('getResult')
            ->with($profileEntity)
        ;

        $subject->preUpdate($eventArgs);
    }

    /*
     * Pre Persist
     */
    public function testPrePersistCreateCustomerAndCard()
    {
        $subject = $this->getSubject();

        $card = new Fridge\SubscriptionBundle\Entity\Card();
        $profileEntity = new Fridge\SubscriptionBundle\Entity\StripeProfile();
        $profileEntity->addCard($card);

        $eventArgs = $this->getEventArgs('Fridge\SubscriptionBundle\Entity\StripeProfile');

        $eventArgs->expects($this->atLeastOnce())
            ->method('getEntity')
            ->will($this->returnValue($profileEntity));

        $subscriptionUpdateOperation = $this->getMockBuilder('Fridge\SubscriptionBundle\Operation\CreateCustomerAndCardOperation')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->operationFactorySpy->expects($this->once())
            ->method('get')
            ->with('customer_and_card.create')
            ->will($this->returnValue($subscriptionUpdateOperation))
        ;

        $subscriptionUpdateOperation->expects($this->once())
            ->method('getResult')
            ->with($card)
        ;

        $subject->prePersist($eventArgs);
    }

    public function testPrePersistCreateCustomer()
    {
        $subject = $this->getSubject();

        $profileEntity = new Fridge\SubscriptionBundle\Entity\StripeProfile();

        $eventArgs = $this->getEventArgs('Fridge\SubscriptionBundle\Entity\StripeProfile');

        $eventArgs->expects($this->atLeastOnce())
            ->method('getEntity')
            ->will($this->returnValue($profileEntity));

        $subscriptionUpdateOperation = $this->getMockBuilder('Fridge\SubscriptionBundle\Operation\CreateCustomerOperation')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->operationFactorySpy->expects($this->once())
            ->method('get')
            ->with('customer.create')
            ->will($this->returnValue($subscriptionUpdateOperation))
        ;

        $subscriptionUpdateOperation->expects($this->once())
            ->method('getResult')
            ->with($profileEntity)
        ;

        $subject->prePersist($eventArgs);
    }

    /*
     * Pre Remove
     */


    public function testPreRemoveCustomer()
    {
        $subject = $this->getSubject();

        $profileEntity = new Fridge\SubscriptionBundle\Entity\StripeProfile();

        $eventArgs = $this->getEventArgs('Fridge\SubscriptionBundle\Entity\StripeProfile');

        $eventArgs->expects($this->atLeastOnce())
            ->method('getEntity')
            ->will($this->returnValue($profileEntity));

        $subscriptionUpdateOperation = $this->getMockBuilder('Fridge\SubscriptionBundle\Operation\RemoveCustomerOperation')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->operationFactorySpy->expects($this->once())
            ->method('get')
            ->with('customer.remove')
            ->will($this->returnValue($subscriptionUpdateOperation))
        ;

        $subscriptionUpdateOperation->expects($this->once())
            ->method('getResult')
            ->with($profileEntity)
        ;

        $subject->preRemove($eventArgs);
    }

} 