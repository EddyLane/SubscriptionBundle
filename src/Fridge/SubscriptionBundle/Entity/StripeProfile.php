<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 28/12/2013
 * Time: 19:46
 */

namespace Fridge\SubscriptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fridge\SubscriptionBundle\Model\StripeProfile as BaseStripeProfile;
use Fridge\SubscriptionBundle\Entity\Card;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\VirtualProperty;


/**
 * Class StripeProfile
 * @package Fridge\SubscriptionBundle\Entity
 * @ExclusionPolicy("all")
 * @ORM\Table(name="fridge_subscription_stripe_profile")
 * @ORM\Entity
 */
class StripeProfile extends BaseStripeProfile
{
    /**
     * @var \Fridge\SubscriptionBundle\Entity\Subscription
     *
     * @Expose
     * @ORM\ManyToOne(targetEntity="Fridge\SubscriptionBundle\Entity\Subscription", cascade={"all"})
     * @ORM\JoinColumn(name="subscription_id", referencedColumnName="id", nullable=true, unique=false)
     */
    protected $subscription;

    /**
     * @ORM\OneToMany(targetEntity="Fridge\SubscriptionBundle\Entity\Card", mappedBy="user", cascade={"all"})
     * @Expose
     * @ORM\OrderBy({"id" = "DESC"})
     * @var ArrayCollection $cards
     */
    protected $cards;

    /**
     * @ORM\OneToOne(targetEntity="Fridge\SubscriptionBundle\Entity\Card", cascade={"all"})
     * @ORM\JoinColumn(name="default_card_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $defaultCard;

    /**
     * @param Card $card
     * @return $this
     */
    public function setDefaultCard(Card $card)
    {
        $this->defaultCard = $card;

        return $this;

    }

    /**
     * @VirtualProperty
     * @return int
     */
    public function getDefaultCardId()
    {
        return $this->getDefaultCard()->getId();
    }

    /**
     * @return \Fridge\SubscriptionBundle\Entity\Card
     */
    public function getDefaultCard()
    {
        return $this->defaultCard;

    }

}
