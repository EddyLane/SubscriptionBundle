<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 11/01/2014
 * Time: 19:45
 */

namespace Fridge\SubscriptionBundle\Operation;

use Fridge\SubscriptionBundle\Model\CardInterface;
use Fridge\SubscriptionBundle\Exception\FridgeCardDeclinedException;

class CreateCustomerAndCardOperation extends AbstractOperation
{

    /**
     * @param CardInterface $card
     * @throws FridgeCardDeclinedException
     */
    public function getResult(CardInterface $card)
    {
        try {

            $customerData = $this->stripeCustomer->create([
                'card' => $card->getToken()
            ]);

            $card->getStripeProfile()->setStripeId($customerData['id']);

            $cardData = $customerData->cards->data[0];

        } catch (\Stripe_CardError $e) {
            throw new FridgeCardDeclinedException($e, 402, $e->getMessage());
        }

        $card
            ->setToken($cardData['id'])
            ->setCardType($cardData['type'])
            ->setNumber($cardData['last4'])
            ->setExpMonth($cardData['exp_month'])
            ->setExpYear($cardData['exp_year']);
    }

} 