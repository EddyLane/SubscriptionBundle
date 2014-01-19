<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 19/01/2014
 * Time: 17:24
 */

namespace Fridge\SubscriptionBundle\Model;

use Fridge\SubscriptionBundle\Model\CardInterface;

abstract class Payment
{
    /**
     * @var \Fridge\SubscriptionBundle\Model\CardInterface
     */
    protected $card;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var int
     */
    protected $amount;

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param \Fridge\SubscriptionBundle\Model\CardInterface $card
     */
    public function setCard(CardInterface $card)
    {
        $this->card = $card;

        return $this;
    }

    /**
     * @return \Fridge\SubscriptionBundle\Entity\Card
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

} 