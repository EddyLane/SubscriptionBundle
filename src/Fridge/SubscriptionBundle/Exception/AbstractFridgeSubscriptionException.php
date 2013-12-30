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
abstract class AbstractFridgeSubscriptionException extends HttpException
{
    protected $original;

    public function __construct(\Exception $original, $statusCode, $message = null, \Exception $previous = null, array $headers = array(), $code = 0)
    {
        $this->original = $original;
        parent::__construct($statusCode, $headers, $message, $code, $previous);
    }

    /**
     * @param mixed $original
     */
    public function setOriginal($original)
    {
        $this->original = $original;
    }

    /**
     * @return mixed
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * @return string
     */
    abstract public function getType();
} 