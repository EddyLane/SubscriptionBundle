<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 01/01/2014
 * Time: 21:08
 */

namespace Fridge\SubscriptionBundle\Operation;


use Fridge\SubscriptionBundle\Model\SubscriptionInterface;

class RemovePlanOperation extends AbstractOperation
{

    public function getResult(SubscriptionInterface $subscription)
    {
        $plan = $this->stripePlan->retrieve($subscription->getId());
        $plan->delete();
    }

} 