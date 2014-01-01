<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 01/01/2014
 * Time: 15:15
 */

namespace Fridge\SubscriptionBundle\Operation;

use Fridge\SubscriptionBundle\Model\StripeProfileInterface;
use Fridge\SubscriptionBundle\Proxy\StripeCustomer;

/**
 * Class AbstractOperation
 * @package Fridge\SubscriptionBundle\Operation
 */
abstract class AbstractOperation
{
    /**
     * @var \Fridge\SubscriptionBundle\Proxy\StripeCustomer
     */
    protected $stripeCustomer;

    /**
     * @param StripeCustomer $stripeCustomer
     */
    public function __construct(StripeCustomer $stripeCustomer)
    {
        $this->stripeCustomer = $stripeCustomer;
    }

    /**
     * @param StripeProfileInterface $stripeProfile
     * @return mixed
     */
    protected function getCustomer(StripeProfileInterface $stripeProfile)
    {
        return $this
            ->stripeCustomer
            ->retrieve($stripeProfile->getStripeId());
    }

} 