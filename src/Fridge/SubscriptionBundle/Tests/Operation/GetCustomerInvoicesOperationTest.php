<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 20/01/2014
 * Time: 20:48
 */

class GetCustomerInvoicesOperationTest extends AbstractOperationTest
{
    protected $invoiceManagerStub;
    protected $subscriptionManagerStub;

    public function setUp()
    {
        parent::setUp();

        $this->invoiceManagerStub = $this->getMockBuilder('Fridge\SubscriptionBundle\Manager\InvoiceManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->subscriptionManagerStub = $this->getMockBuilder('Fridge\SubscriptionBundle\Manager\BaseManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->operation = new Fridge\SubscriptionBundle\Operation\GetCustomerInvoicesOperation(
            $this->invoiceManagerStub,
            $this->subscriptionManagerStub,
            $this->stripeCustomerStub,
            $this->stripePlanStub,
            $this->stripeCardStub
        );
    }

    public function testGetinvoicesOperation()
    {
        $profileMock = $this->getMock('Fridge\SubscriptionBundle\Entity\StripeProfile');

        $profileMock->expects($this->atLeastOnce())
            ->method('getStripeId')
            ->will($this->returnValue('cust_1234'));

        $paymentDummy = $this->getMock('Fridge\SubscriptionBundle\Entity\Invoice');

        $paymentDummy->expects($this->once())
            ->method('setAmount')
            ->with(4000)
            ->will($this->returnValue($paymentDummy));

        $this->invoiceManagerStub->expects($this->any())
            ->method('create')
            ->will($this->returnValue($paymentDummy));

        $subscription = $this->getMock('Fridge\SubscriptionBundle\Entity\Subscription');
        $subscription->expects($this->atLeastOnce())
            ->method('getName')
            ->will($this->returnValue('small'));

        $this->subscriptionManagerStub->expects($this->once())
            ->method('findAll')
            ->will($this->returnValue([
                $subscription
            ]));

        $this->stripeCustomerStub->expects($this->once())
            ->method('getInvoices')
            ->with([
                'customer' => 'cust_1234'
            ])
            ->will($this->returnValue([
                'data' => [
                    [
                        'lines' => [
                            'data' => [
                                [
                                    'amount' => 4000,
                                    'plan' => [
                                        'name' => 'small'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]));

        $result = $this->operation->getResult($profileMock);

        $this->assertCount(1, $result);
        $this->assertEquals($result[0], $paymentDummy);
    }
} 