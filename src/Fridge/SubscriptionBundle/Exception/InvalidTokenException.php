<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 12/01/2014
 * Time: 17:50
 */

namespace Fridge\SubscriptionBundle\Exception;

class InvalidTokenException extends AbstractFridgeSubscriptionException
{
    public function getType()
    {
        return 'token';
    }
}