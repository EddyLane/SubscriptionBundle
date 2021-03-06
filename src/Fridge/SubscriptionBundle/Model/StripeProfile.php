<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 28/12/2013
 * Time: 19:46
 */

namespace Fridge\SubscriptionBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Fridge\SubscriptionBundle\Model\StripeProfileInterface;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Accessor;

/**
 * @ORM\MappedSuperclass
 * @ExclusionPolicy("all")
 */
abstract class StripeProfile implements StripeProfileInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="stripe_id", type="string", nullable=true, options={"default":null})
     */
    protected $stripeId;

    /**
     * @var \DateTime
     * @ORM\Column(name="subscription_start", type="datetime", nullable=true, options={"default":null})
     * @Expose
     */
    protected $subscriptionStart;

    /**
     * @var \DateTime
     * @ORM\Column(name="subscription_end", type="datetime", nullable=true, options={"default":null})
     * @Expose
     */
    protected $subscriptionEnd;

    /**
     * @var ArrayCollection
     */
    protected $cards;



    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \DateTime $subscriptionEnd
     *                                   @return $this
     */
    public function setSubscriptionEnd(\DateTime $subscriptionEnd = null)
    {
        $this->subscriptionEnd = $subscriptionEnd;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionEnd()
    {
        return $this->subscriptionEnd;
    }

    /**
     * @param \DateTime $subscriptionStart
     *                                     @return $this
     */
    public function setSubscriptionStart(\DateTime $subscriptionStart = null)
    {
        $this->subscriptionStart = $subscriptionStart;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionStart()
    {
        return $this->subscriptionStart;
    }

    /**
     * @return String
     */
    public function getStripeId()
    {
        return $this->stripeId;
    }

    /**
     * @param $stripeId
     * @return $this
     */
    public function setStripeId($stripeId)
    {
        $this->stripeId = $stripeId;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @param Card $card
     *                   @return $this
     */
    public function addCard(CardInterface $card)
    {
        $this->cards->add($card);

        $this->setDefaultCard($card);

        $card->setStripeProfile($this);

        return $this;
    }

    /**
     * @param CardInterface $card
     * @return $this
     */
    public function removeCard(CardInterface $card)
    {
        $this->cards->removeElement($card);

        return $this;
    }

    /**
     * @param Subscription $subscription
     * @return $this
     */
    public function setSubscription(SubscriptionInterface $subscription = null)
    {
        $this->subscription = $subscription;

        return $this;
    }

    /**
     * @return Subscription
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * @return mixed
     */
    public function getDefaultCard()
    {
        return $this->defaultCard;
    }

    /**
     * @param CardInterface $card
     * @return $this
     */
    public function setDefaultCard(CardInterface $card)
    {
        $this->defaultCard = $card;

        return $this;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return get_class($this);
    }
}
