<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 18/01/2014
 * Time: 20:16
 */

use Fridge\SubscriptionBundle\Model\Card;

class CardTest extends PHPUnit_Framework_TestCase
{

    public function testToken()
    {
        $card = $this->getCard();
        $this->assertNull($card->getToken());

        $card->setToken('1232415');
        $this->assertEquals('1232415', $card->getToken());
    }

    public function testExpYear()
    {
        $card = $this->getCard();
        $this->assertNull($card->getToken());

        $card->setExpYear(10);
        $this->assertEquals(10, $card->getExpYear());
    }

    public function testExpMonth()
    {
        $card = $this->getCard();
        $this->assertNull($card->getExpMonth());

        $card->setExpMonth(10);
        $this->assertEquals(10, $card->getExpMonth());
    }

    public function testMapCardType()
    {
        $card = $this->getCard();

        $card->setCardType('visa');
        $this->assertEquals(1, $card->getCardType());
        $this->assertEquals('Visa', $card->getCardTypeName());

        $card->setCardType('mastercard');
        $this->assertEquals(2, $card->getCardType());
        $this->assertEquals('MasterCard', $card->getCardTypeName());

        $card->setCardType('american express');
        $this->assertEquals(3, $card->getCardType());
        $this->assertEquals('American Express', $card->getCardTypeName());
    }

    public function testGetNumber()
    {
        $card = $this->getCard();

        $card->setCardType('visa');
        $card->setNumber(1234);
        $this->assertEquals('**** **** **** 1234', $card->getNumber());

        $card->setCardType('mastercard');
        $card->setNumber(1234);
        $this->assertEquals('**** **** **** 1234', $card->getNumber());

        $card->setCardType('american express');
        $card->setNumber(1234);
        $this->assertEquals('**** ****** *1234', $card->getNumber());
    }

    public function testStripeProfile()
    {
        $card = $this->getCard();

        $profile = new Fridge\SubscriptionBundle\Entity\StripeProfile();
        $card->setStripeProfile($profile);
        $this->assertEquals($profile, $card->getStripeProfile());
    }

    public function testBelongsToTrue()
    {
        $card = $this->getCard();

        $stripeProfile = $this->getMock('Fridge\SubscriptionBundle\Entity\StripeProfile');
        $stripeProfile->expects($this->atLeastOnce())
            ->method('getId')
            ->will($this->returnValue(1))
        ;

        $card->setStripeProfile($stripeProfile);

        $this->assertTrue($card->belongsTo($stripeProfile));
    }

    public function testBelongsToFalse()
    {
        $card = $this->getCard();

        $stripeProfile = $this->getMock('Fridge\SubscriptionBundle\Entity\StripeProfile');
        $stripeProfile->expects($this->atLeastOnce())
            ->method('getId')
            ->will($this->returnValue(1))
        ;
        $stripeProfileTwo = $this->getMock('Fridge\SubscriptionBundle\Entity\StripeProfile');
        $stripeProfileTwo->expects($this->atLeastOnce())
            ->method('getId')
            ->will($this->returnValue(2))
        ;
        $card->setStripeProfile($stripeProfile);

        $this->assertFalse($card->belongsTo($stripeProfileTwo));
    }
    /**
     * @return User
     */
    protected function getCard()
    {
        return $this->getMockForAbstractClass('Fridge\SubscriptionBundle\Model\Card');
    }
}