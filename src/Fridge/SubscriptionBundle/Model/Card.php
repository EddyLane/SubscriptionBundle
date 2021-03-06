<?php

namespace Fridge\SubscriptionBundle\Model;

use Doctrine\ORM\Mapping as ORM;

use Fridge\SubscriptionBundle\Model\CardInterface;
use Fridge\SubscriptionBundle\Model\StripeProfileInterface;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Card
 *
 * @ORM\MappedSuperclass
 * @ExclusionPolicy("all")
 */
abstract class Card implements CardInterface
{
    /**
     * @var string
     *
     * @Expose
     * @Accessor(getter="getNumber")
     * @ORM\Column(name="number", type="string", length=4)
     */
    protected $number;

    /**
     * @var integer
     *
     * @Expose
     * @Accessor(getter="getCardType")
     * @ORM\Column(name="card_type", type="smallint")
     */
    protected $cardType;

    /**
     * @var integer
     *
     * @Expose
     * @ORM\Column(name="exp_month", type="integer")
     */
    protected $expMonth;

    /**
     * @var integer
     *
     * @Expose
     * @ORM\Column(name="exp_year", type="integer")
     */
    protected $expYear;

    /**
     * @var string
     * @ORM\Column(name="token", type="string")
     */
    protected $token;


    public function __construct($token = null)
    {
        if (!is_null($token)) {
            $this->setToken($token);
        }
    }

    /**
     * @param $name
     * @return int
     */
    public final static function mapCardType($name)
    {
        switch (strtolower($name)) {
            case 'visa':
                return self::CARD_TYPE_VISA;
            case 'american express':
                return self::CARD_TYPE_AMERICAN_EXPRESS;
            case 'mastercard':
                return self::CARD_TYPE_MASTERCARD;
        }
    }

    /**
     * @param $type
     * @return mixed|string
     */
    public final static function mapCardTypeName($type)
    {
        switch ($type) {
            case 1:
                return self::CARD_NAME_VISA;
            case 2:
                return self::CARD_NAME_MASTERCARD;
            case 3:
                return self::CARD_NAME_AMERICAN_EXPRESS;
        }
    }

    /**
     * @param $type
     * @return mixed|string
     */
    public final static function mapCardFormat($type)
    {
        switch ($type) {
            case 1:
                return self::CARD_FORMAT_VISA;
            case 2:
                return self::CARD_FORMAT_MASTERCARD;
            case 3:
                return self::CARD_FORMAT_AMERICAN_EXPRESS;
        }
    }
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = (string) $token;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set number
     *
     * @param  string $number
     * @return Card
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        $format = self::mapCardFormat($this->cardType);

        return substr_replace($format, $this->number, - strlen($this->number));
    }

    /**
     * Set cardType
     *
     * @param  integer $cardType
     * @return Card
     */
    public function setCardType($cardType)
    {
        $this->cardType = self::mapCardType($cardType);

        return $this;
    }

    /**
     * Get cardType
     *
     * @return integer
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * @VirtualProperty
     * @return string
     */
    public function getCardTypeName()
    {
        return self::mapCardTypeName($this->getCardType());
    }

    /**
     * @return $this
     */
    public function setStripeProfile($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param $expMonth
     * @return $this
     */
    public function setExpMonth($expMonth)
    {
        $this->expMonth = $expMonth;

        return $this;
    }

    /**
     * @param $expYear
     * @return $this
     */
    public function setExpYear($expYear)
    {
        $this->expYear = $expYear;

        return $this;
    }

    /**
     * @return int
     */
    public function getExpMonth()
    {
        return $this->expMonth;
    }

    /**
     * @return int
     */
    public function getExpYear()
    {
        return $this->expYear;
    }

    /**
     * @return StripeProfile
     */
    public function getStripeProfile()
    {
        return $this->user;
    }

    /**
     * @param  StripeProfile $stripeProfile
     * @return bool
     */
    public function belongsTo(StripeProfileInterface $stripeProfile)
    {
        return $stripeProfile->getId() === $this->getStripeProfile()->getId();
    }

    /**
     * @return mixed|String
     */
    public function getStripeProfileId()
    {
        return $this->getStripeProfile()->getStripeId();
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return get_class($this);
    }
}
