<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 28/12/2013
 * Time: 19:46
 */

namespace Fridge\SubscriptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Expose;
use Fridge\SubscriptionBundle\Model\StripeProfile as BaseStripeProfile;

/**
 * Class StripeProfile
 * @package Fridge\SubscriptionBundle\Entity
 *
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
}
