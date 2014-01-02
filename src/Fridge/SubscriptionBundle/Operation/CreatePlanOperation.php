<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 01/01/2014
 * Time: 21:08
 */

namespace Fridge\SubscriptionBundle\Operation;


use Fridge\SubscriptionBundle\Model\SubscriptionInterface;

class CreatePlanOperation extends AbstractOperation
{

    public function getResult(SubscriptionInterface $subscription)
    {
        if(!$subscription->getId()) {
            throw new \ErrorException('Subscription must have already been persisted');
        }

        $this->stripePlan->create([
            "amount" => $subscription->getPrice(),
            "interval" => "month",
            "name" => $subscription->getDescription(),
            "currency" => "gbp",
            "id" => $subscription->getId()
        ]);
    }
}