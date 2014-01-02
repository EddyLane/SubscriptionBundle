<?php
/**
 * Created by PhpStorm.
 * User: eddylane
 * Date: 02/01/2014
 * Time: 16:24
 */

namespace Fridge\SubscriptionBundle\Controller;

use Fridge\SubscriptionBundle\Event\StripeWebhookEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class WebhookController
 * @package Fridge\SubscriptionBundle\Controller
 */
class WebhookController extends ContainerAware
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function postWebhookAction(Request $request)
    {
        $content = json_decode($request->getContent(), true);

        $event = is_array($content) && isset($content['type']) ? $content['type'] : 'unknown';

        $this->container->get('event_dispatcher')->dispatch(
            'fridge.stripe_event.' . $event,
            new StripeWebhookEvent($event, $content)
        );

        return new JsonResponse([], 200);
    }

} 