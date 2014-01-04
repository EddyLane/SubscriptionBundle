<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 04/01/2014
 * Time: 18:00
 */

class RemoveSubscriptionOperationTest
{
    protected $operation;

    protected $stripePlanStub;

    protected $stripeCustomerStub;

    public function setUp()
    {
        $this->stripePlanStub = $this->getMock('Fridge\SubscriptionBundle\Proxy\StripePlan');

        $this->stripeCustomerStub = $this->getMock('Fridge\SubscriptionBundle\Proxy\StripeCustomer');

        $this->operation = new \Fridge\SubscriptionBundle\Operation\RemoveSubscriptionOperation(
            $this->stripeCustomerStub,
            $this->stripePlanStub
        );
    }

    public function testUpdateSubscription()
    {
        $stripeCustomerMock = $this->getMock('Stripe_Customer');

        $stripeCustomerMock->expects($this->once())
            ->method('cancelSubscription');

        $this->stripeCustomerStub
            ->expects($this->once())
            ->method('retrieve')
            ->with(1)
            ->will($this->returnValue($stripeCustomerMock));

        $stripeProfileStub = $this->getMock('Fridge\SubscriptionBundle\Entity\StripeProfile');

        $subscriptionDummy = $this->getMock('Fridge\SubscriptionBundle\Entity\Subscription');

        $subscriptionDummy->expects($this->any())
            ->method('getId')
            ->will($this->returnValue(2));

        $stripeProfileStub
            ->expects($this->any())
            ->method('getSubscription')
            ->will($this->returnValue($subscriptionDummy));

        $stripeProfileStub->expects($this->atLeastOnce())
            ->method('setSubscriptionStart')
            ->with(null);

        $stripeProfileStub->expects($this->atLeastOnce())
            ->method('setSubscriptionEnd')
            ->with(null);

        $stripeProfileStub
            ->expects($this->any())
            ->method('getStripeId')
            ->will($this->returnValue(1));

        $this->operation->getResult($stripeProfileStub);
    }
} 