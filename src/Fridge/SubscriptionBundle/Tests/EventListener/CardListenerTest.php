<?php

class CardListener extends PHPUnit_Framework_TestCase
{


    private $cardListener;

    private $stripeCustomerMock;

    public function setUp()
    {
        $this->stripeCustomerMock = $this->getMockBuilder('Fridge\SubscriptionBundle\Proxy\StripeCustomer')
            ->disableOriginalConstructor()
            ->getMock();

        $this->cardListener = new \Fridge\SubscriptionBundle\EventListener\CardListener(
            $this->stripeCustomerMock,
            'Fridge/SubscriptionBundle/Entity/Card'
        );
    }

    public function testSuccessfulPrePersist()
    {
        $stub = $this->getMockBuilder('Doctrine\ORM\Event\LifecycleEventArgs')
            ->disableOriginalConstructor()
            ->getMock();

        $cardEntity = $this->getMock('Fridge\SubscriptionBundle\Entity\Card');

        $cardEntity->expects($this->once())
            ->method('getClassName')
            ->will($this->returnValue('Fridge\SubscriptionBundle\Entity\Card'));

        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $stub->expects($this->once())
            ->method('getEntity')
            ->will($this->returnValue($cardEntity));

        $stub->expects($this->once())
            ->method('getEntityManager')
            ->will($this->returnValue($entityManager));

        $classMetadata = $this->getMockBuilder('Doctrine\ORM\Mapping\ClassMetadata')
            ->disableOriginalConstructor()
            ->getMock();

        $classMetadata->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('Fridge/SubscriptionBundle/Entity/Card'));

        $entityManager->expects($this->once())
            ->method('getClassMetadata')
            ->with('Fridge\SubscriptionBundle\Entity\Card')
            ->will($this->returnValue($classMetadata));


        ////////////

        $stripeProfile = $this->getMock('Fridge\SubscriptionBundle\Entity\StripeProfile');

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
            ->with(1)
            ->will($this->returnValue($cardEntity));

        $cardEntity->expects($this->once())
            ->method('setCardType')
            ->with(1)
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

        $this->stripeCustomerMock->expects($this->once())
            ->method('retrieve')
            ->with('123456789')
            ->will($this->returnValue($stripeCustomer));

        $this->cardListener->prePersist($stub);
    }
}
