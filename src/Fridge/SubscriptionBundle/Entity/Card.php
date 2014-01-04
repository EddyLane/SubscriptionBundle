<?php

namespace Fridge\SubscriptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fridge\SubscriptionBundle\Model\Card as BaseCard;

use JMS\Serializer\Annotation\Expose;

/**
 * Class Card
 * @package Fridge\SubscriptionBundle\Entity
 * @ORM\Table("fridge_subscription_card")
 * @ORM\Entity
 */
class Card extends BaseCard
{
    /**
     * @var integer
     * @Expose
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Fridge\SubscriptionBundle\Entity\StripeProfile", inversedBy="cards")
     * @ORM\JoinColumn(name="stripe_profile_id", referencedColumnName="id")
     */
    protected $user;
}
