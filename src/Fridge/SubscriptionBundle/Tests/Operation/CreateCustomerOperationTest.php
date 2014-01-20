<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 20/01/2014
 * Time: 20:48
 */

class CreateCustomerOperationTest extends AbstractOperationTest
{

    public function setUp()
    {
        parent::setUp();

        $this->operation = new Fridge\SubscriptionBundle\Operation\CreateCustomerOperation(
            $this->stripeCustomerStub,
            $this->stripePlanStub,
            $this->stripeCardStub
        );
    }


    public function testCreateCustomerAndCard()
    {

        $stripeProfileMock = $this->getMock('Fridge\SubscriptionBundle\Entity\StripeProfile');

        $stripeProfileMock->expects($this->once())
            ->method('setStripeId')
            ->with('cust_124515')
        ;

        $this->stripeCustomerStub->expects($this->once())
            ->method('create')
            ->with([
            ])
            ->will($this->returnValue([
                'id' => 'cust_124515'
            ]))
        ;

        $this->operation->getResult($stripeProfileMock);
    }
} 