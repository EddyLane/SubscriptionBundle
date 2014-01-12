<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 30/12/2013
 * Time: 16:03
 */

namespace Fridge\SubscriptionBundle\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class AbstractFridgeSubscriptionException
 * @package Fridge\SubscriptionBundle\Exception
 */
abstract class AbstractFridgeSubscriptionException extends \Exception
{

    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    abstract public function getType();
}
