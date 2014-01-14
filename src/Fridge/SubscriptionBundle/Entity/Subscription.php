<?php

namespace Fridge\SubscriptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fridge\SubscriptionBundle\Model\Subscription as BaseSubscription;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class Subscription
 * @package Fridge\SubscriptionBundle\Entity
 * @ORM\Table("fridge_subscription")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class Subscription extends BaseSubscription
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
