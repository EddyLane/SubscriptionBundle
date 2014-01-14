<?php

namespace Fridge\SubscriptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fridge\SubscriptionBundle\Model\Card as BaseCard;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;


/**
 * Class Card
 * @package Fridge\SubscriptionBundle\Entity
 *
 * @ORM\Table("fridge_subscription_card")
 * @ExclusionPolicy("all")
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
     * @ORM\ManyToOne(targetEntity="Fridge\SubscriptionBundle\Entity\StripeProfile", inversedBy="cards", cascade={"persist"})
     * @ORM\JoinColumn(name="stripe_profile_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
