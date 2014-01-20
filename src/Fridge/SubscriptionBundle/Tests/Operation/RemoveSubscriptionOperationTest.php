<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 20/01/2014
 * Time: 22:57
 */

class RemoveSubscriptionOperationTest extends AbstractOperationTest
{
    public function setUp()
    {
        parent::setUp();

        $this->operation = new Fridge\SubscriptionBundle\Operation\RemoveSubscriptionOperation(
            $this->stripeCustomerStub,
            $this->stripePlanStub,
            $this->stripeCardStub
        );
    }

    public function testRemoveSubscriptionOperation()
    {
        $stripeProfileMock = $this->getMock('Fridge\SubscriptionBundle\Entity\StripeProfile');
    }

}
