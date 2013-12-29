<?php

namespace Fridge\SubscriptionBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\RequestParam;

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
        $cardManager = $this->container->get('uvd.payment.card_manager');

        $card = $cardManager->find($id);

        if(!$card || !$card->belongsTo($this->getUser())) {
            throw new HttpException(403, 'Forbidden');
        }

        $cardManager->remove($card, true);
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCardsAction()
    {
        return $this->getUser()->getCards();
    }

    /**
     * @RequestParam(name="token", description="Stripe token.")
     * @View(statusCode=201)
     */
    public function postCardAction(ParamFetcher $paramFetcher)
    {
        $cardManager = $this->container->get('uvd.payment.card_manager');

        $card = $cardManager->create($paramFetcher->get('token'));

        $cardManager->save($card, true);

        return $card;
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