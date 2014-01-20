<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 20/01/2014
 * Time: 20:48
 */

class GetCustomerPaymentsOperationTest extends AbstractOperationTest
{
    protected $paymentManagerStub;

    public function setUp()
    {
        parent::setUp();

        $this->paymentManagerStub = $this->getMockBuilder('Fridge\SubscriptionBundle\Manager\PaymentManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->operation = new Fridge\SubscriptionBundle\Operation\GetCustomerPaymentsOperation(
            $this->paymentManagerStub,
            $this->stripeCustomerStub,
            $this->stripePlanStub,
            $this->stripeCardStub
        );
    }

    public function testGetPaymentsOperation()
    {
        $profileMock = $this->getMock('Fridge\SubscriptionBundle\Entity\StripeProfile');

        $profileMock->expects($this->atLeastOnce())
            ->method('getStripeId')
            ->will($this->returnValue('cust_1234'));

        $paymentDummy = $this->getMock('Fridge\SubscriptionBundle\Entity\Payment');

        $cardsCollectionMock = $this->getMock('Doctrine\Common\Collections\ArrayCollection');
        $firstCardMock = $this->getMock('Fridge\SubscriptionBundle\Entity\Card');

        $paymentDummy->expects($this->once())
            ->method('setCard')
            ->with($firstCardMock)
            ->will($this->returnValue($paymentDummy))
        ;

        $paymentDummy->expects($this->once())
            ->method('setAmount')
            ->with(4000)
            ->will($this->returnValue($paymentDummy))
        ;

        $paymentDummy->expects($this->once())
            ->method('setCreatedAt')
            ->with('@' . 1390156717, true)
            ->will($this->returnValue($paymentDummy))
        ;

        $this->paymentManagerStub->expects($this->any())
             ->method('create')
            ->will($this->returnValue($paymentDummy));

        $firstCardMock->expects($this->once())
                ->method('getToken')
                ->will($this->returnValue('card_1245'));

        $cardsCollectionMock->expects($this->once())
            ->method('toArray')
            ->will($this->returnValue([
                $firstCardMock
            ]));

        $profileMock->expects($this->once())
            ->method('getCards')
            ->will($this->returnValue($cardsCollectionMock));

        $this->stripeCustomerStub->expects($this->once())
            ->method('getCharges')
            ->with([
                'customer' => 'cust_1234'
            ])
            ->will($this->returnValue([
                'data' => [
                    [
                        'amount' => 4000,
                        'created' => 1390156717,
                        'card' => [
                            'id' => 'card_1245'
                        ]
                    ]
                ]
            ]));

        $result = $this->operation->getResult($profileMock);

        $this->assertCount(1, $result);
        $this->assertEquals($result[0], $paymentDummy);
    }
} 