<?php

namespace UVd\SubscriptionBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Class SubscriptionController
 * @package UVd\SubscriptionBundle\Controller
 */
class SubscriptionController extends ContainerAware
{
    /**
     * @return array
     */
    public function getSubscriptionsAction()
    {
        $manager = $this->container->get('fridge.subscription.manager.subscription_manager');
        return $manager->findAll();
    }

} 