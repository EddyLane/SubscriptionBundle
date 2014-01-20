<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 20/01/2014
 * Time: 20:48
 */

class RemoveCustomerOperationTest extends AbstractOperationTest
{

    public function setUp()
    {
        parent::setUp();

        $this->operation = new Fridge\SubscriptionBundle\Operation\RemoveCustomerOperation(
            $this->stripeCustomerStub,
            $this->stripePlanStub,
            $this->stripeCardStub
        );
    }


    public function testRemoveCustomerOperation()
    {

        $stripeProfileMock = $this->getMock('Fridge\SubscriptionBundle\Entity\StripeProfile');

        $stripeProfileMock->expects($this->atLeastOnce())
            ->method('getStripeId')
            ->will($this->returnValue('cust_124515'))
        ;

        $this->stripeCustomerStub->expects($this->once())
            ->method('remove')
            ->with([
                'id' => 'cust_124515'
            ])
        ;

        $this->operation->getResult($stripeProfileMock);
    }
} 