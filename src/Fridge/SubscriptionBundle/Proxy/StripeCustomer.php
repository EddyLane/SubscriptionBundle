<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 29/12/2013
 * Time: 02:01
 */

namespace Fridge\SubscriptionBundle\Proxy;

use Stripe_Customer;

class StripeCustomer extends AbstractStripeProxy
{
    /**
     * @param array $id
     * @return array
     */
    public function retrieve(array $data)
    {
        return $this->client->getCustomer($data);
    }

    /**
     * @param array $data
     * @return array
     */
    public function update(array $data)
    {
        return $this->client->updateCustomer($data);
    }

    /**
     * @param array $data
     * @return array
     */
    public function create(array $data)
    {
        return $this->client->createCustomer($data);
    }

    /**
     * @param array $data
     * @return array
     */
    public function remove(array $data)
    {
        return $this->client->deleteCustomer($data);
    }

    /**
     * @param array $data
     * @return array
     */
    public function updateSubscription(array $data)
    {
        return $this->client->updateSubscription($data);
    }

    /**
     * @param array $data
     * @return array
     */
    public function cancelSubscription(array $data)
    {
        return $this->client->cancelSubscription($data);
    }

    /**
     * @param array $data
     * @return array
     */
    public function getCharges(array $data = null)
    {
        return $this->client->getCharges($data);
    }

    /**
     * @param array $data
     * @return array
     */
    public function getInvoices(array $data)
    {
        return $this->client->getInvoices($data);
    }


}
