<?php

namespace Fridge\SubscriptionBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

/**
 * Class SubscriptionController
 * @package Fridge\SubscriptionBundle\Controller
 */
class SubscriptionController extends ContainerAware
{
    /**
     * Query all Subscription entities
     *
     * @return View
     */
    public function getSubscriptionsAction()
    {
        $manager = $this->container->get('fridge.subscription.manager.subscription_manager');
        $view = View::create($manager->findAll());
        return $this->container->get('fos_rest.view_handler')->handle($view);
    }

} 