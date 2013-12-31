<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 29/12/2013
 * Time: 15:50
 */

namespace Fridge\SubscriptionBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AbstractEntityEventListener
 * @package Fridge\SubscriptionBundle\EventListener
 */
abstract class AbstractEntityEventListener
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @param Container $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return object
     */
    private function getSecurityContext()
    {
        return $this->container->get('security.context');
    }

    /**
     * @return mixed
     */
    protected function getSecurityContextUser()
    {
        return $this->getSecurityContext()->getToken()->getUser();
    }

}
