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
use Fridge\SubscriptionBundle\Exception\InvalidTokenException;
use Fridge\SubscriptionBundle\Exception\FridgeCardDeclinedException;

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

            throw new FridgeCardDeclinedException($e->getMessage(), 402);

        } catch (\Stripe_InvalidRequestError $e) {

            throw new InvalidTokenException('Invalid token', 402);

        }

        $card
            ->setToken($cardData['id'])
            ->setCardType($cardData['type'])
            ->setNumber($cardData['last4'])
            ->setExpMonth($cardData['exp_month'])
            ->setExpYear($cardData['exp_year']);
    }

} 