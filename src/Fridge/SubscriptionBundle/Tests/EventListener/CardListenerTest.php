<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 25/01/2014
 * Time: 16:00
 */

class CardListenerTest extends AbstractListenerTest
{
    protected $operationFactorySpy;

    protected function getSubject($enabled = true)
    {
        $this->operationFactorySpy = $this->getMockBuilder('Fridge\SubscriptionBundle\Factory\OperationFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $subject = new Fridge\SubscriptionBundle\EventListener\CardListener(
            $this->operationFactorySpy,
            $enabled
        );

        $subject->setEntityClass('Fridge\SubscriptionBundle\Model\Card');

        return $subject;
    }

    public function testPrePersistActionsDontHappenIfCardAlreadyHasANumber()
    {
        $subject = $this->getSubject();

        $cardEntity = new Fridge\SubscriptionBundle\Entity\Card();
        $cardEntity->setNumber(1234);

        $eventArgs = $this->getEventArgs('Fridge\SubscriptionBundle\Entity\Card');

        $eventArgs->expects($this->atLeastOnce())
            ->method('getEntity')
            ->will($this->returnValue($cardEntity));

        $this->operationFactorySpy->expects($this->never())
            ->method('get');

        $subject->prePersist($eventArgs);
    }

    public function testPrePersistActionsHappenIfCardHasNoNumber()
    {
        $subject = $this->getSubject();

        $cardEntity = new Fridge\SubscriptionBundle\Entity\Card();

        $eventArgs = $this->getEventArgs('Fridge\SubscriptionBundle\Entity\Card');

        $eventArgs->expects($this->atLeastOnce())
            ->method('getEntity')
            ->will($this->returnValue($cardEntity));

        $cardCreateOperation = $this->getMockBuilder('Fridge\SubscriptionBundle\Operation\CreateCardOperation')
            ->disableOriginalConstructor()
            ->getMock();

        $cardCreateOperation->expects($this->once())
            ->method('getResult')
            ->with($cardEntity)
         ;

        $this->operationFactorySpy->expects($this->once())
            ->method('get')
            ->with('card.create')
            ->will($this->returnValue($cardCreateOperation))
        ;

        $subject->prePersist($eventArgs);
    }

    public function testPreRemoveActionsHappenIfCardHasNoToken()
    {
        $subject = $this->getSubject();

        $cardEntity = new Fridge\SubscriptionBundle\Entity\Card();


        $eventArgs = $this->getEventArgs('Fridge\SubscriptionBundle\Entity\Card');

        $eventArgs->expects($this->atLeastOnce())
            ->method('getEntity')
            ->will($this->returnValue($cardEntity));

        $this->operationFactorySpy->expects($this->never())
            ->method('get')
        ;

        $subject->preRemove($eventArgs);
    }


    public function testPrePersistActionsHappenIfCardHasToken()
    {
        $subject = $this->getSubject();

        $cardEntity = new Fridge\SubscriptionBundle\Entity\Card();
        $cardEntity->setToken(123456789);

        $eventArgs = $this->getEventArgs('Fridge\SubscriptionBundle\Entity\Card');

        $eventArgs->expects($this->atLeastOnce())
            ->method('getEntity')
            ->will($this->returnValue($cardEntity));

        $cardCreateOperation = $this->getMockBuilder('Fridge\SubscriptionBundle\Operation\RemoveCardOperation')
            ->disableOriginalConstructor()
            ->getMock();

        $cardCreateOperation->expects($this->once())
            ->method('getResult')
            ->with($cardEntity)
        ;

        $this->operationFactorySpy->expects($this->once())
            ->method('get')
            ->with('card.remove')
            ->will($this->returnValue($cardCreateOperation))
        ;

        $subject->preRemove($eventArgs);
    }
} 