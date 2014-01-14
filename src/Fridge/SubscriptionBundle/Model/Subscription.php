<?php

namespace Fridge\SubscriptionBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Fridge\SubscriptionBundle\Model\SubscriptionInterface;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Subscription
 *
 * @ORM\MappedSuperclass
 * @ExclusionPolicy("all")
 */
abstract class Subscription implements SubscriptionInterface
{

    /**
     * @var string
     * @Expose
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    protected $name;

    /**
     * @var string
     * @Expose
     * @ORM\Column(name="price", type="decimal")
     */
    protected $price;

    /**
     * @var string
     * @Expose
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    /**
     * Set name
     *
     * @param  string       $name
     * @return Subscription
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param  string       $price
     * @return Subscription
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param  string       $description
     * @return Subscription
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * to String
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return get_class($this);
    }
}
