<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 20/01/2014
 * Time: 20:48
 */

class RemoveCardOperationTest extends AbstractOperationTest
{

    public function setUp()
    {
        parent::setUp();

        $this->operation = new Fridge\SubscriptionBundle\Operation\RemoveCardOperation(
            $this->stripeCustomerStub,
            $this->stripePlanStub,
            $this->stripeCardStub
        );
    }

    public function testCreatePlan()
    {
        $cardSpy = $this->getMock('Fridge\SubscriptionBundle\Entity\Card');

        $cardSpy->expects($this->atLeastOnce())
            ->method('getToken')
            ->will($this->returnValue(1));

        $cardSpy->expects($this->atLeastOnce())
            ->method('getStripeProfileId')
            ->will($this->returnValue(1234));

        $this->stripeCardStub->expects($this->once())
            ->method('remove')
            ->with([
                "id" => 1,
                "customer" => 1234,
            ]);
        ;

        $this->operation->getResult($cardSpy);
    }
} 