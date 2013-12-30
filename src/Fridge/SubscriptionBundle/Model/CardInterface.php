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
    /**
     * @return $this
     */
    public function setStripeProfile($user);

    /**
     * @param StripeProfile $stripeProfile
     * @return bool
     */
    public function belongsTo(StripeProfileInterface $stripeProfile);

    /**
     * Set cardType
     *
     * @param integer $cardType
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
     * @param string $number
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
}