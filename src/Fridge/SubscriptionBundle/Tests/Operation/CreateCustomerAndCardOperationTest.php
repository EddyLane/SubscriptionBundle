<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 17/01/2014
 * Time: 23:02
 */

class CreateCustomerAndCardOperationTest extends PHPUnit_Framework_TestCase
{

    protected $operation;

    protected $stripePlanStub;

    protected $stripeCustomerStub;

    public function setUp()
    {
        $this->stripePlanStub = $this->getMock('Fridge\SubscriptionBundle\Proxy\StripePlan');

        $this->stripeCustomerStub = $this->getMock('Fridge\SubscriptionBundle\Proxy\StripeCustomer');

        $this->operation = new \Fridge\SubscriptionBundle\Operation\CreateCustomerAndCardOperation(
            $this->stripeCustomerStub,
            $this->stripePlanStub
        );
    }


    public function testCreateCardAndSubscription()
    {
        $stripeProfile = $this->getMock('Fridge\SubscriptionBundle\Entity\StripeProfile');
        $cardEntity = $this->getMock('Fridge\SubscriptionBundle\Entity\Card');

        $cardEntity->expects($this->once())
            ->method('getToken')
            ->will($this->returnValue('987654321'));

        $cardEntity->expects($this->once())
            ->method('getStripeProfile')
            ->will($this->returnValue($stripeProfile));


        $stipeCustomerDummy = \Stripe_Customer::constructFrom([
            'id' => 'cust_fake',
            'cards'=> [
                [
                    "id" => "card_103K2y2UK86V8cuWu0DC1oSt",
                    "last4" => "4242",
                    "type" => "Visa",
                    "exp_month" => 11,
                    "exp_year" => 2015
                ]
            ]
        ]);

        $stripCustomerStub = $this->getMock('Stripe_Customer');


        $this->stripeCustomerStub->expects($this->once())
            ->method('create')
            ->with([
                'card' => '987654321'
            ])
            ->will($this->returnValue($stipeCustomerDummy));


        /////////

        $cardEntity->expects($this->once())
            ->method('setToken')
            ->with(1)
            ->will($this->returnValue($cardEntity));

        $cardEntity->expects($this->once())
            ->method('setCardType')
            ->with('visa')
            ->will($this->returnValue($cardEntity));

        $cardEntity->expects($this->once())
            ->method('setNumber')
            ->with(4242)
            ->will($this->returnValue($cardEntity));

        $cardEntity->expects($this->once())
            ->method('setExpMonth')
            ->with(11)
            ->will($this->returnValue($cardEntity));

        $cardEntity->expects($this->once())
            ->method('setExpYear')
            ->with(2014)
            ->will($this->returnValue($cardEntity));


        $this->operation->getResult($cardEntity);
    }



} 