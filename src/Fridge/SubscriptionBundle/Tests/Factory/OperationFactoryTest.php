<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 23/01/2014
 * Time: 19:45
 */

use Fridge\SubscriptionBundle\Factory\OperationFactory;

class OperationFactoryTest extends PHPUnit_Framework_TestCase
{
    protected $operationFactory;

    protected $stripeCustomer;

    protected $stripePlan;

    protected $stripeCard;

    protected $paymentManager;

    protected $invoiceManager;

    protected $subscriptionManager;

    public function setUp()
    {
        $this->stripeCustomer = $this->getMockBuilder('Fridge\SubscriptionBundle\Proxy\StripeCustomer')
            ->disableOriginalConstructor()
            ->getMock();

        $this->stripePlan = $this->getMockBuilder('Fridge\SubscriptionBundle\Proxy\StripePlan')
            ->disableOriginalConstructor()
            ->getMock();

        $this->stripeCard = $this->getMockBuilder('Fridge\SubscriptionBundle\Proxy\StripeCard')
            ->disableOriginalConstructor()
            ->getMock();

        $this->paymentManager = $this->getMockBuilder('Fridge\SubscriptionBundle\Manager\PaymentManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->invoiceManager = $this->getMockBuilder('Fridge\SubscriptionBundle\Manager\InvoiceManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->subscriptionManager = $this->getMockBuilder('Fridge\SubscriptionBundle\Manager\BaseManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->operationFactory = new OperationFactory(
            $this->stripeCustomer,
            $this->stripePlan,
            $this->stripeCard,
            $this->paymentManager,
            $this->invoiceManager,
            $this->subscriptionManager
        );
    }

    public function testGetCreatCustomerOperation()
    {
        $this->assertInstanceOf('Fridge\SubscriptionBundle\Operation\CreateCustomerOperation', $this->operationFactory->get('customer.create'));
    }

    public function testGetUpdateCustomerOperation()
    {
        $this->assertInstanceOf('Fridge\SubscriptionBundle\Operation\UpdateCustomerOperation', $this->operationFactory->get('customer.update'));
    }

    public function testGetRemoveCustomerOperation()
    {
        $this->assertInstanceOf('Fridge\SubscriptionBundle\Operation\RemoveCustomerOperation', $this->operationFactory->get('customer.remove'));
    }

    public function testGetCustomerPaymentsOperation()
    {
        $this->assertInstanceOf('Fridge\SubscriptionBundle\Operation\GetCustomerPaymentsOperation', $this->operationFactory->get('customer.charges.get'));
    }

    public function testGetCreateCustomerAndCardOperation()
    {
        $this->assertInstanceOf('Fridge\SubscriptionBundle\Operation\CreateCustomerAndCardOperation', $this->operationFactory->get('customer_and_card.create'));
    }

    public function testCreateCardOperation()
    {
        $this->assertInstanceOf('Fridge\SubscriptionBundle\Operation\CreateCardOperation', $this->operationFactory->get('card.create'));
    }

    public function testRemoveCardOperation()
    {
        $this->assertInstanceOf('Fridge\SubscriptionBundle\Operation\RemoveCardOperation', $this->operationFactory->get('card.remove'));
    }

    public function testCreatePlanOperation()
    {
        $this->assertInstanceOf('Fridge\SubscriptionBundle\Operation\CreatePlanOperation', $this->operationFactory->get('plan.create'));
    }

    public function testRemovePlanOperation()
    {
        $this->assertInstanceOf('Fridge\SubscriptionBundle\Operation\RemovePlanOperation', $this->operationFactory->get('plan.remove'));
    }

    public function testUpdateSubscriptionOperation()
    {
        $this->assertInstanceOf('Fridge\SubscriptionBundle\Operation\UpdateSubscriptionOperation', $this->operationFactory->get('subscription.update'));
    }

    public function testRemoveSubscriptionOperation()
    {
        $this->assertInstanceOf('Fridge\SubscriptionBundle\Operation\RemoveSubscriptionOperation', $this->operationFactory->get('subscription.remove'));
    }

    public function testGetCustomerInvoicesOperation()
    {
        $this->assertInstanceOf('Fridge\SubscriptionBundle\Operation\GetCustomerInvoicesOperation', $this->operationFactory->get('customer.invoices.get'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testNoOperationException()
    {
        $this->operationFactory->get('nothing.operation');
    }

} 