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
use Fridge\SubscriptionBundle\Exception\InvalidTokenException;
use ZfrStripe\Exception\CardErrorException;
use ZfrStripe\Exception\ServerErrorException;
use ZfrStripe\Exception\ValidationErrorException;

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

            $cardData = $customerData['cards']['data'][0];

        } catch (CardErrorException $e) {
            throw new FridgeCardDeclinedException($e->getMessage(), 402);
        }
         catch (ValidationErrorException $e) {
             throw new InvalidTokenException($e->getMessage(), 402);
         }

        $card
            ->setToken($cardData['id'])
            ->setCardType($cardData['type'])
            ->setNumber($cardData['last4'])
            ->setExpMonth($cardData['exp_month'])
            ->setExpYear($cardData['exp_year'])
        ;
    }

} 