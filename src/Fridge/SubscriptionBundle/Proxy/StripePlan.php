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
     * @return array
     */
    public function create(array $data)
    {

        return $this->client->createPlan($data);
    }

    /**
     * @param array $data
     * @return array
     */
    public function retrieve(array $data)
    {
        return $this->client->getPlan($data);
    }

    /**
     * @param array $data
     * @return array
     */
    public function remove(array $data)
    {
        return $this->client->deletePlan($data);
    }

}
