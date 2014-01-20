<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 20/01/2014
 * Time: 20:48
 */

class CreateCustomerAndCardOperationTest extends AbstractOperationTest
{

    public function setUp()
    {
        parent::setUp();

        $this->operation = new Fridge\SubscriptionBundle\Operation\CreateCustomerAndCardOperation(
            $this->stripeCustomerStub,
            $this->stripePlanStub,
            $this->stripeCardStub
        );
    }

    public function testCreateCustomerAndCard()
    {
        $cardSpy = $this->getMock('Fridge\SubscriptionBundle\Entity\Card');

        $cardSpy->expects($this->atLeastOnce())
            ->method('getToken')
            ->will($this->returnValue(123));

        $stripeProfileMock = $this->getMock('Fridge\SubscriptionBundle\Entity\StripeProfile');

        $stripeProfileMock->expects($this->once())
            ->method('setStripeId')
            ->with('cust_124515')
        ;

        $cardSpy->expects($this->atLeastOnce())
            ->method('getStripeProfile')
            ->will($this->returnValue($stripeProfileMock));

        $this->stripeCustomerStub->expects($this->once())
            ->method('create')
            ->with([
                "card" => 123,
            ])
            ->will($this->returnValue([
                'id' => 'cust_124515',
                'cards' => [
                    'data' => [
                        [
                            'id' => 'card_12345',
                            'type' => 'visa',
                            'last4' => '1234',
                            'exp_month' => '04',
                            'exp_year' => '2015'
                        ]
                    ]
                ]
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