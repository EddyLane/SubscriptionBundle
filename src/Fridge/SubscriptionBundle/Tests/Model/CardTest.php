<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 18/01/2014
 * Time: 20:16
 */

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



    /**
     * @return User
     */
    protected function getCard()
    {
        return $this->getMockForAbstractClass('Fridge\SubscriptionBundle\Model\Card');
    }
}