<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 29/12/2013
 * Time: 02:01
 */

namespace Fridge\SubscriptionBundle\Proxy;

use Stripe_Plan;

class StripePlan extends AbstractStripeProxy
{
    /**
     * @param  array $data
     * @return mixed
     */
    public function create($data)
    {
        return Stripe_Plan::create($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function retrieve($id)
    {
        return Stripe_Plan::retrieve($id);
    }

}
