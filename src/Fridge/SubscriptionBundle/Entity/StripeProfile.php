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
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity
 * @ORM\Table(name="fridge_stripe_profile")
 *
 * @ExclusionPolicy("all")
 */
class StripeProfile
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
     * @ORM\OneToMany(targetEntity="Fridge\SubscriptionBundle\Entity\Payment", mappedBy="user", cascade={"all"})
     *
     * @var ArrayCollection $payments
     */
    protected $payments;

    /**
     * @var \Fridge\SubscriptionBundle\Entity\Subscription
     *
     * @Expose
     * @ORM\ManyToOne(targetEntity="Fridge\SubscriptionBundle\Entity\Subscription")
     * @ORM\JoinColumn(name="subscription_id", referencedColumnName="id", nullable=true, unique=false)
     */
    protected $subscription;

    /**
     * @ORM\OneToMany(targetEntity="Fridge\PaymentBundle\Entity\Card", mappedBy="user", cascade={"all"})
     * @Expose
     * @ORM\OrderBy({"created" = "DESC"})
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
     * @return string
     */
    public function __toString()
    {
        return $this->getUsername() . '(' . $this->getEmail() . ')';
    }

    /**
     * @return ArrayCollection
     */
    public function getCards()
    {
        return $this->cards;
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