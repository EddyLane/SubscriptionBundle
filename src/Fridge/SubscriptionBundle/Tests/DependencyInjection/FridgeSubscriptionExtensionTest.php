<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 21/01/2014
 * Time: 21:47
 */

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Fridge\SubscriptionBundle\DependencyInjection\FridgeSubscriptionExtension;
use Symfony\Component\Yaml\Parser;

class FridgeSubscriptionExtensionTest extends PHPUnit_Framework_TestCase
{
    /** @var ContainerBuilder */
    protected $configuration;

    /**
     * getEmptyConfig
     *
     * @return array
     */
    protected function getEmptyConfig()
    {
        $yaml = <<<EOF
fridge_subscription:
    user_class: Fridge\UserBundle\Entity\User
    stripe_sk: "%stripe_test_secret_key%"
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    protected function getFullConfig()
    {
        $yaml = <<<EOF
fridge_subscription:
    user_class: Fridge\UserBundle\Entity\User
    stripe_sk: "%stripe_test_secret_key%"
    enable_listeners: true
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUThrowsExceptionUnlessUserClassSet()
    {
        $loader = new FridgeSubscriptionExtension();
        $config = $this->getEmptyConfig();
        unset($config['user_class']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionUnlessStripeSecretKeySet()
    {
        $loader = new FridgeSubscriptionExtension();
        $config = $this->getEmptyConfig();
        unset($config['stripe_sk']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionUnlessEnableListenersIsBoolean()
    {
        $loader = new FridgeSubscriptionExtension();
        $config = $this->getFullConfig();
        unset($config['enable_listeners']);
        $config['enable_listeners'] = 'foo';
        $loader->load(array($config), new ContainerBuilder());
    }

    protected function tearDown()
    {
        unset($this->configuration);
    }
} 