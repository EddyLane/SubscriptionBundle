<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 13/01/2014
 * Time: 20:12
 */

namespace Fridge\SubscriptionBundle\Exception;


class NoCardsException extends AbstractFridgeSubscriptionException
{

    public function __construct($message = "User has no selected card", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getType()
    {
        return 'card';
    }

} 