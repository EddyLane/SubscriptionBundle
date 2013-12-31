<?php

namespace Fridge\SubscriptionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerAware;
use FOS\RestBundle\View\View;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class CardController
 * @package Fridge\SubscriptionBundle\Controller
 */
class CardController extends ContainerAware
{

    /**
     * @param $id
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function deleteCardAction($id)
    {
        $cardManager = $this->container->get('fridge.subscription.manager.card_manager');

        $card = $cardManager->find($id);

        if (!$card || !$card->belongsTo($this->getUser()->getStripeProfile())) {
            throw new HttpException(403, 'Forbidden');
        }

        $cardManager->remove($card, true);

        return $this->handleView();
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCardsAction()
    {
        return $this->getUser()->getCards();
    }

    /**
     * @param  Request $request
     * @return mixed
     */
    public function postCardAction(Request $request)
    {
        $cardManager = $this->container->get('fridge.subscription.manager.card_manager');

        $card = $cardManager->create($request->request->get('token'));

        $user = $this->getUser();

        $user->getStripeProfile()->addCard($card);

        $em = $this->container->get('doctrine')->getManager();

        $em->persist($user);

        $em->flush();

        return $this->handleView($card);
    }

    /**
     * @return mixed
     */
    protected function getUser()
    {
        return $this->container->get('security.context')->getToken()->getUser();
    }

    /**
     * Convenience function to return a view with data
     *
     * @param $data
     * @return mixed
     */
    protected function handleView($data = null)
    {
        $view = View::create($data);
        $view->setFormat('json');

        return $this->container->get('fos_rest.view_handler')->handle($view);
    }
}
