<?php
/**
 * Created by PhpStorm.
 * User: eddylane
 * Date: 03/01/2014
 * Time: 14:02
 */

class RemovePlanOperationTest extends AbstractOperationTest
{

    public function setUp()
    {
        parent::setUp();

        $this->operation = new Fridge\SubscriptionBundle\Operation\RemovePlanOperation(
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

    public function testRemovePlan()
    {
        $subscriptionStub = $this->getMock('Fridge\SubscriptionBundle\Entity\Subscription');

        $subscriptionStub->expects($this->atLeastOnce())
            ->method('getId')
            ->will($this->returnValue(1));

        $this->stripePlanStub->expects($this->once())
            ->method('remove');

        $this->operation->getResult($subscriptionStub);
    }

} 