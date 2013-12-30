<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 28/12/2013
 * Time: 19:46
 */

namespace Fridge\SubscriptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fridge\SubscriptionBundle\Entity\Payment;
use Doctrine\Common\Collections\ArrayCollection;
use Fridge\SubscriptionBundle\Model\StripeProfileInterface;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity
 * @ORM\Table(name="fridge_subscription_stripe_profile")
 *
 * @ExclusionPolicy("all")
 */
class StripeProfile implements StripeProfileInterface
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
     * @ORM\OneToMany(targetEntity="Fridge\SubscriptionBundle\Entity\Payment", mappedBy="stripeProfile", cascade={"all"})
     *
     * @var ArrayCollection $payments
     */
    protected $payments;

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


    public function __construct()
    {
        $this->cards = new ArrayCollection();
        $this->payments = new ArrayCollection();
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
     * @return $this
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
     * @return $this
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
     * @param Payment $payment
     * @return $this
     */
    public function addPayment(Payment $payment)
    {
        $this->payments[] = $payment;

        return $this;
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
    public function getPayments()
    {
        return $this->payments;
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
     * @return $this
     */
    public function addCard(Card $card)
    {
        $this->cards->add($card);

        $card->setStripeProfile($this);

        return $this;
    }

    /**
     * @param Subscription $subscription
     * @return $this
     */
    public function setSubscription(Subscription $subscription = null)
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

}