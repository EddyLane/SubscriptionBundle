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
use ZfrStripe\Exception\CardErrorException;
use ZfrStripe\Exception\ServerErrorException;
use ZfrStripe\Exception\ValidationErrorException;

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

            $cardData = $this->stripeCard->create([
                'card' => $card->getToken(),
                'customer' => $card->getStripeProfile()->getStripeId()
            ]);

        } catch (CardErrorException $e) {

            throw new FridgeCardDeclinedException($e->getMessage(), 402);

        } catch (ValidationErrorException $e) {

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