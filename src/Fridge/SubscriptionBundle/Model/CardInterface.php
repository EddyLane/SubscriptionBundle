<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 30/12/2013
 * Time: 11:51
 */
namespace Fridge\SubscriptionBundle\Model;

/**
 * Interface CardInterface
 * @package Fridge\SubscriptionBundle\Model
 */
interface CardInterface
{
    const CARD_TYPE_VISA = 1;
    const CARD_TYPE_MASTERCARD = 2;
    const CARD_TYPE_AMERICAN_EXPRESS = 3;
    const CARD_TYPE_DISCOVER = 4;
    const CARD_TYPE_DINERS_CLUB = 5;
    const CARD_TYPE_JCB = 6;

    const CARD_NAME_VISA = 'Visa';
    const CARD_NAME_MASTERCARD = 'MasterCard';
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
     * @return $this
     */
    public function setStripeProfile($user);

    /**
     * @param  StripeProfile $stripeProfile
     * @return bool
     */
    public function belongsTo(StripeProfileInterface $stripeProfile);

    /**
     * Set cardType
     *
     * @param  integer $cardType
     * @return Card
     */
    public function setCardType($cardType);

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber();

    /**
     * @param $name
     * @return int
     */
    public static function mapCardType($name);

    /**
     * @param $type
     * @return mixed
     */
    public static function mapCardTypeName($type);

    /**
     * @return string
     */
    public function getToken();

    /**
     * @param $token
     * @return $this
     */
    public function setToken($token);

    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * @param $expYear
     * @return $this
     */
    public function setExpYear($expYear);

    /**
     * Set number
     *
     * @param  string $number
     * @return Card
     */
    public function setNumber($number);

    /**
     * @return StripeProfile
     */
    public function getStripeProfile();

    /**
     * @param $expMonth
     * @return $this
     */
    public function setExpMonth($expMonth);

    /**
     * Get cardType
     *
     * @return integer
     */
    public function getCardType();

    /**
     * @param $type
     * @return mixed
     */
    public static function mapCardFormat($type);

    /**
     * @VirtualProperty
     * @return string
     */
    public function getCardTypeName();

    /**
     * @return mixed
     * @return string
     */
    public function getStripeProfileId();
}
