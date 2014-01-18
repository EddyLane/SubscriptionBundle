<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 01/01/2014
 * Time: 21:08
 */

namespace Fridge\SubscriptionBundle\Operation;

use Fridge\SubscriptionBundle\Model\SubscriptionInterface;

/**
 * Class CreatePlanOperation
 * @package Fridge\SubscriptionBundle\Operation
 */
class CreatePlanOperation extends AbstractOperation
{

    /**
     * @param SubscriptionInterface $subscription
     * @return array
     * @throws \ErrorException
     */
    public function getResult(SubscriptionInterface $subscription)
    {
        if(!$subscription->getId()) {
            throw new \ErrorException('Subscription must have already been persisted');
        }

        return $this->stripePlan->create([
            "amount" => (int) $subscription->getPrice(),
            "interval" => "month",
            "name" => $subscription->getName(),
            "currency" => "gbp",
            "id" => (string) $subscription->getId()
        ]);
    }
}