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
        if(!$subscription->getId()) {
            throw new \ErrorException('Subscription must have been persisted');
        }

        $this->stripePlan->remove([ 'id' => $subscription->getId() ]);
    }

} 