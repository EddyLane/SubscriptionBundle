<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 04/01/2014
 * Time: 17:00
 */

class RemoveCardOperationTest extends PHPUnit_Framework_TestCase
{

    protected $operation;

    protected $stripePlanStub;

    protected $stripeCustomerStub;

    public function setUp()
    {
        $this->stripePlanStub = $this->getMock('Fridge\SubscriptionBundle\Proxy\StripePlan');

        $this->stripeCustomerStub = $this->getMock('Fridge\SubscriptionBundle\Proxy\StripeCustomer');

        $this->operation = new \Fridge\SubscriptionBundle\Operation\RemoveCardOperation(
            $this->stripeCustomerStub,
            $this->stripePlanStub
        );
    }


    public function testRemoveCard()
    {
        $stripeCustomer = $this->getMock('stdClass');

        $cardsMock = $this->getMock('Stripe_List');

        $stripeCardMock = $this->getMock('Stripe_Card');

        $stripeCardMock->expects($this->once())
            ->method('delete');

        $cardsMock->expects($this->once())
            ->method('retrieve')
            ->with(1)
            ->will($this->returnValue($stripeCardMock));

        $stripeCustomer->cards = $cardsMock;

        ///////////////////////

        $this->stripeCustomerStub
            ->expects($this->once())
            ->method('retrieve')
            ->with(1)
            ->will($this->returnValue($stripeCustomer));

        $cardStub = $this->getMock('Fridge\SubscriptionBundle\Entity\Card');

        $cardStub
            ->expects($this->once())
            ->method('getToken')
            ->will($this->returnValue(1));

        $profileStub = $this->getMock('Fridge\SubscriptionBundle\Entity\StripeProfile');

        $profileStub->expects($this->atLeastOnce())
                    ->method('getStripeId')
                    ->will($this->returnValue(1));

        $cardStub
            ->expects($this->once())
            ->method('getStripeProfile')
            ->will($this->returnValue($profileStub));

        //make stripe profile.

        $this->operation->getResult($cardStub);
    }

} 