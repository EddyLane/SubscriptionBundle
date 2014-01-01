<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 01/01/2014
 * Time: 18:11
 */

namespace Fridge\SubscriptionBundle\Operation;

use Fridge\SubscriptionBundle\Model\CardInterface;

/**
 * Class RemoveCardOperation
 * @package Fridge\SubscriptionBundle\Operation
 */
class RemoveCardOperation extends AbstractOperation
{

    /**
     * @param CardInterface $card
     * @throws FridgeCardDeclinedException
     */
    public function getResult(CardInterface $card)
    {
        try {
            $customer = $this->getCustomer($card->getStripeProfile());

            $customer
                ->cards
                ->retrieve($card->getToken())
                ->delete()
            ;

        } catch (\Stripe_CardError $e) {
            throw new FridgeCardDeclinedException($e, 402, $e->getMessage());
        }
    }

} 