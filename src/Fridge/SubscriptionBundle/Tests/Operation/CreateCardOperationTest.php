<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 04/01/2014
 * Time: 17:39
 */

class CreateCardOperationTest extends PHPUnit_Framework_TestCase {

    protected $operation;

    protected $stripePlanStub;

    protected $stripeCustomerStub;

    public function setUp()
    {
        $this->stripePlanStub = $this->getMock('Fridge\SubscriptionBundle\Proxy\StripePlan');

        $this->stripeCustomerStub = $this->getMock('Fridge\SubscriptionBundle\Proxy\StripeCustomer');

        $this->operation = new \Fridge\SubscriptionBundle\Operation\CreateCardOperation(
            $this->stripeCustomerStub,
            $this->stripePlanStub
        );
    }

    public function testUpdateSubscription()
    {
        $stripeProfile = $this->getMock('Fridge\SubscriptionBundle\Entity\StripeProfile');
        $cardEntity = $this->getMock('Fridge\SubscriptionBundle\Entity\Card');

        $cardEntity->expects($this->once())
            ->method('getStripeProfile')
            ->will($this->returnValue($stripeProfile));

        $stripeProfile->expects($this->once())
            ->method('getStripeId')
            ->will($this->returnValue('123456789'));

        $stripeCustomer = $this->getMock('stdClass');

        $cardsMock = $this->getMock('Stripe_List');

        $cardsMock->expects($this->once())
            ->method('create')
            ->with(['card' => '987654321'])
            ->will($this->returnValue([
                'id' => 1,
                'type' => 'visa',
                'last4' => 4242,
                'exp_month' => 11,
                'exp_year' => 2014
            ]));

        $stripeCustomer->cards = $cardsMock;

        $cardEntity->expects($this->once())
            ->method('getToken')
            ->will($this->returnValue('987654321'));

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

        $this->stripeCustomerStub->expects($this->once())
            ->method('retrieve')
            ->with('123456789')
            ->will($this->returnValue($stripeCustomer));

        $this->operation->getResult($cardEntity);
    }

} 