<?php

namespace Fridge\SubscriptionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Fridge\SubscriptionBundle\Model\CardInterface;
use Fridge\SubscriptionBundle\Model\StripeProfileInterface;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Fridge\SubscriptionBundle\Entity\StripeProfile;

/**
 * Card
 *
 * @ORM\Table("fridge_subscription_card")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class Card implements CardInterface
{
    const CARD_TYPE_VISA = 1;
    const CARD_TYPE_MASTERCARD = 2;
    const CARD_TYPE_AMERICAN_EXPRESS = 3;
    const CARD_TYPE_DISCOVER = 4;
    const CARD_TYPE_DINERS_CLUB = 5;
    const CARD_TYPE_JCB = 6;

    const CARD_NAME_VISA = 'Visa';
    const CARD_NAME_MASTERCARD = 'Mastercard';
    const CARD_NAME_AMERICAN_EXPRESS = 'American Express';
    const CARD_NAME_DISCOVER = 'Discover';
    const CARD_NAME_DINERS_CLUB = 'Diners Club';
    const CARD_NAME_JCB = 'JCB';

    const CARD_FORMAT_VISA = '**** **** **** ****';
    const CARD_FORMAT_MASTERCARD = '**** **** **** ****';
    const CARD_FORMAT_AMERICAN_EXPRESS = '**** ****** *****';
    const CARD_FORMAT_DISCOVER = '**** **** **** ****';
    const CARD_FORMAT_DINERS_CLUB = '**** **** **** ****';
    const CARD_FORMAT_JCB = '**** **** **** ****';

    /**
     * @var integer
     * @Expose
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Expose
     * @Accessor(getter="getNumber")
     * @ORM\Column(name="number", type="string", length=4)
     */
    private $number;

    /**
     * @var integer
     *
     * @Expose
     * @Accessor(getter="getCardType")
     * @ORM\Column(name="card_type", type="smallint")
     */
    private $cardType;

    /**
     * @var integer
     *
     * @Expose
     * @ORM\Column(name="exp_month", type="integer")
     */
    private $expMonth;

    /**
     * @var integer
     *
     * @Expose
     * @ORM\Column(name="exp_year", type="integer")
     */
    private $expYear;

    /**
     * @var string
     * @ORM\Column(name="token", type="string")
     */
    private $token;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Fridge\SubscriptionBundle\Entity\StripeProfile", inversedBy="cards")
     * @ORM\JoinColumn(name="stripe_profile_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="Fridge\SubscriptionBundle\Entity\Payment", mappedBy="card", cascade={"all"})
     *
     * @var ArrayCollection $payments
     */
    protected $payments;

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
    public static function mapCardType($name)
    {
        switch (strtolower($name)) {
            case 'visa':
                return self::CARD_TYPE_VISA;
            case 'american express':
                return self::CARD_TYPE_AMERICAN_EXPRESS;
            case 'mastercard':
                return self::CARD_TYPE_MASTERCARD;
            default:
                return self::CARD_TYPE_VISA;

        }
    }

    public static function mapCardTypeName($type)
    {
        switch ($type) {
            case 1:
                return self::CARD_NAME_VISA;
            case 2:
                return self::CARD_NAME_MASTERCARD;
        }

    }

    public static function mapCardFormat($type)
    {
        switch ($type) {
            case 1:
                return self::CARD_FORMAT_VISA;
            case 2:
                return self::CARD_FORMAT_MASTERCARD;
            case 3:
                return self::CARD_FORMAT_AMERICAN_EXPRESS;
            default:
                return self::CARD_FORMAT_VISA;
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
        $this->token = $token;

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
        return self::mapCardTypeName($this->cardType);
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

    public function getClassName()
    {
        return get_class($this);
    }
}
