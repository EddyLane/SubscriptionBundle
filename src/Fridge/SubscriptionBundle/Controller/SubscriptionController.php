<?php

namespace Fridge\SubscriptionBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as RestAnnotations;
use FOS\RestBundle\View\View;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

        $subscriptions = $manager->findAll();

        return $this->handleView($manager);
    }

    /**
     * Subscribe to a subscription
     *
     * @param $id
     * @return View
     */
    public function postSubscriptionSubscribeAction($id)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        $stripeProfile = $user->getStripeProfile();

        $subscription = $this->container->get('fridge.subscription.manager.subscription_manager')->find($id);

        $stripeProfile->setSubscription($subscription);

        $userManager = $this->container->get('fridge.user.manager.user_manager');

        $userManager->save($user, true);

        return $this->handleView($user);
    }

    /**
     * Convinience function to return a view with data
     *
     * @param $data
     * @return mixed
     */
    protected function handleView($data)
    {
        $view = View::create($data);

        return $this->container->get('fos_rest.view_handler')->handle($view);
    }

} 