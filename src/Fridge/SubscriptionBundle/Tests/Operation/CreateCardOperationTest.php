<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 20/01/2014
 * Time: 20:48
 */

class CreateCardOperationTest extends AbstractOperationTest
{

    public function setUp()
    {
        parent::setUp();

        $this->operation = new Fridge\SubscriptionBundle\Operation\CreateCardOperation(
            $this->stripeCustomerStub,
            $this->stripePlanStub,
            $this->stripeCardStub
        );
    }

    public function testNoTokenException()
    {
        $this->setExpectedException('\ErrorException');

        $cardSpy = $this->getMock('Fridge\SubscriptionBundle\Entity\Card');

        $cardSpy->expects($this->atLeastOnce())
            ->method('getToken')
            ->will($this->returnValue(null));

        $this->operation->getResult($cardSpy);
    }

    public function testNoStripeProfileException()
    {
        $this->setExpectedException('\ErrorException');

        $cardSpy = $this->getMock('Fridge\SubscriptionBundle\Entity\Card');

        $cardSpy->expects($this->atLeastOnce())
            ->method('getToken')
            ->will($this->returnValue(1));

        $cardSpy->expects($this->atLeastOnce())
            ->method('getStripeProfile')
            ->will($this->returnValue(null));

        $this->operation->getResult($cardSpy);
    }

    public function testCreatePlan()
    {
        $cardSpy = $this->getMock('Fridge\SubscriptionBundle\Entity\Card');

        $cardSpy->expects($this->atLeastOnce())
            ->method('getToken')
            ->will($this->returnValue(1));

        $cardSpy->expects($this->atLeastOnce())
            ->method('getStripeProfile')
            ->will($this->returnValue($this->getMock('Fridge\SubscriptionBundle\Entity\StripeProfile')));

        $cardSpy->expects($this->atLeastOnce())
            ->method('getStripeProfileId')
            ->will($this->returnValue(1234));

        $this->stripeCardStub->expects($this->once())
            ->method('create')
            ->with([
                "card" => 1,
                "customer" => 1234,
            ])
            ->will($this->returnValue([
                'id' => 'card_12345',
                'type' => 'visa',
                'last4' => '1234',
                'exp_month' => '04',
                'exp_year' => '2015'
            ]))
        ;

        $cardSpy->expects($this->atLeastOnce())
            ->method('setToken')
            ->with('card_12345')
            ->will($this->returnValue($cardSpy))
        ;
        $cardSpy->expects($this->atLeastOnce())
            ->method('setCardType')
            ->with('visa')
            ->will($this->returnValue($cardSpy))
        ;
        $cardSpy->expects($this->atLeastOnce())
            ->method('setNumber')
            ->with('1234')
            ->will($this->returnValue($cardSpy))
        ;
        $cardSpy->expects($this->atLeastOnce())
            ->method('setExpMonth')
            ->with('04')
            ->will($this->returnValue($cardSpy))
        ;
        $cardSpy->expects($this->atLeastOnce())
            ->method('setExpYear')
            ->with('2015')
            ->will($this->returnValue($cardSpy))
        ;

        $this->operation->getResult($cardSpy);
    }
} 