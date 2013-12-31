<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 30/12/2013
 * Time: 16:06
 */

namespace Fridge\SubscriptionBundle\Exception;

class FridgeCardDeclinedException extends AbstractFridgeSubscriptionException
{
    public function getType()
    {
        return 'card';
    }
}
