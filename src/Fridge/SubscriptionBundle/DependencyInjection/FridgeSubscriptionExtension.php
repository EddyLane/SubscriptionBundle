<?php

namespace Fridge\SubscriptionBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class FridgeSubscriptionExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {

        if (!isset($configs[0]['user_class'])) {
            throw new \InvalidArgumentException(
                'The "user_class" option must be set for the "fridge_subscription" bundle'
            );
        }

        if (!isset($configs[0]['stripe_sk'])) {
            throw new \InvalidArgumentException(
                'The "stripe_sk" option must be set for the "fridge_subscription" bundle'
            );
        }

        $container->setParameter(
            'fridge_subscription.user_class',
            $configs[0]['user_class']
        );

        $container->setParameter(
            'fridge_subscription.stripe_sk',
            $configs[0]['stripe_sk']
        );

        $container->setParameter(
            'fridge_subscription.enable_listeners',
            $configs[0]['enable_listeners']
        );

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
