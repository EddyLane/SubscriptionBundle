<?php
/**
 * Created by PhpStorm.
 * User: eddylane
 * Date: 03/01/2014
 * Time: 14:02
 */

class CreatePlanOperationTest extends PHPUnit_Framework_TestCase
{
    protected $operation;

    protected $stripePlanStub;

    protected $stripeCustomerStub;

    public function setUp()
    {
        $this->stripePlanStub = $this->getMock('Fridge\SubscriptionBundle\Proxy\StripePlan');

        $this->stripeCustomerStub = $this->getMock('Fridge\SubscriptionBundle\Proxy\StripeCustomer');

        $this->operation = new \Fridge\SubscriptionBundle\Operation\RemovePlanOperation(
            $this->stripeCustomerStub,
            $this->stripePlanStub
        );
    }

    public function testNoIdException()
    {
        $this->setExpectedException('\ErrorException');

        $subscriptionStub = $this->getMock('Fridge\SubscriptionBundle\Entity\Subscription');

        $subscriptionStub->expects($this->once())
                         ->method('getId')
                         ->will($this->returnValue(null));

        $this->operation->getResult($subscriptionStub);
    }

    public function testRemovePlan()
    {
        $subscriptionStub = $this->getMock('Fridge\SubscriptionBundle\Entity\Subscription');

        $subscriptionStub->expects($this->any())
            ->method('getId')
            ->will($this->returnValue(1));

        $stripePlanMock = $this->getMock('Stripe_Plan');

        $this->stripePlanStub->expects($this->once())
            ->method('retrieve')
            ->with(1)
            ->will($this->returnValue($stripePlanMock));

        $stripePlanMock->expects($this->once())
            ->method('delete');

        $this->operation->getResult($subscriptionStub);
    }
} 