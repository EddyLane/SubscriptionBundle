<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 18/01/2014
 * Time: 15:50
 */

namespace Fridge\SubscriptionBundle\Proxy;


class StripeCard extends AbstractStripeProxy
{

    /**
     * @param array $data
     * @return array
     */
    public function create(array $data)
    {
        return $this->client->createCard($data);
    }

    /**
     * @param array $data
     * @return array
     */
    public function remove(array $data)
    {
        return $this->client->deleteCard($data);
    }

} 