<?php
/**
 * Created by PhpStorm.
 * User: eddylane
 * Date: 02/01/2014
 * Time: 16:18
 */

namespace Fridge\SubscriptionBundle\Exception;


class UpdateSubscriptionException extends \Exception
{
    public function getMessage()
    {
        return 'You cannot update a subscription entity; this is because you cannot update a subscription on Stripe. Please delete the subscription and re-create it. You can also update the name manually.';
    }
} 