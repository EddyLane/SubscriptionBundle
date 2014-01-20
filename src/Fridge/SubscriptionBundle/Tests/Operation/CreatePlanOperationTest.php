<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 20/01/2014
 * Time: 20:48
 */

class CreatePlanOperationTest extends AbstractOperationTest
{

    public function setUp()
    {
        parent::setUp();

        $this->operation = new Fridge\SubscriptionBundle\Operation\CreatePlanOperation(
            $this->stripeCustomerStub,
            $this->stripePlanStub,
            $this->stripeCardStub
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

        $subscriptionStub->expects($this->atLeastOnce())
            ->method('getId')
            ->will($this->returnValue(1));

        $subscriptionStub->expects($this->atLeastOnce())
            ->method('getName')
            ->will($this->returnValue('Test subscription'));

        $subscriptionStub->expects($this->atLeastOnce())
            ->method('getPrice')
            ->will($this->returnValue(1000));

        $this->stripePlanStub->expects($this->once())
            ->method('create')
            ->with([
                "amount" => 1000,
                "interval" => "month",
                "name" => 'Test subscription',
                "currency" => "gbp",
                "id" => 1
            ])
        ;

        $this->operation->getResult($subscriptionStub);
    }
} 