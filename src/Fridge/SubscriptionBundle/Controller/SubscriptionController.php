<?php

namespace Fridge\SubscriptionBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
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

        $manager = $this->container->get('fridge.subscription.manager.subscription_manager');

        $subscription = $manager->find($id);

        $stripeProfile = $user->getStripeProfile()->setSubscription($subscription);

        $em = $this->container->get('doctrine')->getManager();

        $em->persist($user);

        $em->flush();

        return $this->handleView($user);
    }

    /**
     * Convenience function to return a view with data
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