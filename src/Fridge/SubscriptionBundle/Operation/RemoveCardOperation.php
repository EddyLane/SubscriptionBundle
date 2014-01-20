<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 01/01/2014
 * Time: 18:11
 */

namespace Fridge\SubscriptionBundle\Operation;

use Fridge\SubscriptionBundle\Model\CardInterface;
use Fridge\SubscriptionBundle\Exception\FridgeCardDeclinedException;
use ZfrStripe\Exception\CardErrorException;
use ZfrStripe\Exception\ServerErrorException;
use ZfrStripe\Exception\ValidationErrorException;
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

            $this->stripeCard->remove([
                'id' => $card->getToken(),
                'customer' => $card->getStripeProfileId()
            ]);

        }
        catch (CardErrorException $e) {
            throw new FridgeCardDeclinedException($e->getMessage(), 402);
        }
        catch (ValidationErrorException $e) {
            throw new FridgeCardDeclinedException($e->getMessage(), 402);
        }

    }

} 