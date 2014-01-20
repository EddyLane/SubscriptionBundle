<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 20/01/2014
 * Time: 20:47
 */

abstract class AbstractOperationTest extends PHPUnit_Framework_TestCase
{
    protected $operation;

    protected $stripePlanStub;

    protected $stripeCustomerStub;

    protected $stripeCardStub;

    public function setUp()
    {
        $this->stripePlanStub = $this->getMockBuilder('Fridge\SubscriptionBundle\Proxy\StripePlan')
            ->disableOriginalConstructor()
            ->getMock();

        $this->stripeCustomerStub = $this->getMockBuilder('Fridge\SubscriptionBundle\Proxy\StripeCustomer')
            ->disableOriginalConstructor()
            ->getMock();

        $this->stripeCardStub = $this->getMockBuilder('Fridge\SubscriptionBundle\Proxy\StripeCard')
            ->disableOriginalConstructor()
            ->getMock();
    }

} 