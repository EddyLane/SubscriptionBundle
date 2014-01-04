<?php
/**
 * Created by PhpStorm.
 * User: eddylane
 * Date: 03/01/2014
 * Time: 14:02
 */

class RemovePlanOperationTest extends PHPUnit_Framework_TestCase
{
    protected $operation;

    protected $stripePlanStub;

    protected $stripeCustomerStub;

    public function setUp()
    {
        $this->stripePlanStub = $this->getMock('Fridge\SubscriptionBundle\Proxy\StripePlan');

        $this->stripeCustomerStub = $this->getMock('Fridge\SubscriptionBundle\Proxy\StripeCustomer');

        $this->operation = new \Fridge\SubscriptionBundle\Operation\CreatePlanOperation(
            $this->stripeCustomerStub,
            $this->stripePlanStub
        );
    }

    public function testNoIdException()
    {
        $this->setExpectedException('\ErrorException');

        $subscriptionStub = $this->getMock('Fridge\SubscriptionBundle\Entity\Subscription');

        $subscriptionStub->expects($this->atLeastOnce())
                         ->method('getId')
                         ->will($this->returnValue(null));

        $this->operation->getResult($subscriptionStub);
    }

    public function testCreatePlan()
    {
        $subscriptionStub = $this->getMock('Fridge\SubscriptionBundle\Entity\Subscription');

        $subscriptionStub->expects($this->any())
            ->method('getId')
            ->will($this->returnValue(1));

        $subscriptionStub->expects($this->atLeastOnce())
            ->method('getPrice')
            ->will($this->returnValue(10000));

        $subscriptionStub->expects($this->atLeastOnce())
            ->method('getDescription')
            ->will($this->returnValue("A description"));

        $this->stripePlanStub->expects($this->once())
            ->method('create')
            ->with([
                "amount" => 10000,
                "interval" => "month",
                "name" => "A description",
                "currency" => "gbp",
                "id" => 1
            ]);

        $this->operation->getResult($subscriptionStub);
    }
} 