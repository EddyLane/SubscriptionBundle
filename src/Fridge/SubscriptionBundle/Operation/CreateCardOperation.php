<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 01/01/2014
 * Time: 15:10
 */

namespace Fridge\SubscriptionBundle\Operation;


use Fridge\SubscriptionBundle\Model\CardInterface;
use Fridge\SubscriptionBundle\Proxy\StripeCustomer;

/**
 * Class CreateCardOperation
 * @package Fridge\SubscriptionBundle\Operation
 */
class CreateCardOperation extends AbstractOperation
{

    /**
     * @param CardInterface $card
     * @throws FridgeCardDeclinedException
     */
    public function getResult(CardInterface $card)
    {

        try {

            $customer = $this->getCustomer($card->getStripeProfile());

            $cardData = $customer
                ->cards
                ->create(['card' => $card->getToken()]);

        } catch (\Stripe_CardError $e) {
            throw new FridgeCardDeclinedException($e, 402, $e->getMessage());
        }

        $card
            ->setToken($cardData->id)
            ->setCardType($cardData->type)
            ->setNumber($cardData->last4)
            ->setExpMonth($cardData->exp_month)
            ->setExpYear($cardData->exp_year);
    }

} 