<?php
/**
 * Created by PhpStorm.
 * User: eddylane
 * Date: 02/01/2014
 * Time: 15:44
 */

namespace Fridge\SubscriptionBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AddPlanCommand
 * @package Fridge\SubscriptionBundle\Command
 */
class AddPlanCommand extends ContainerAwareCommand
{


    protected function configure()
    {
        $this->setName('fridge:plan:create')
             ->setDescription('Create a new plan and optionally persist it to Stripe')
             ->setDefinition([
                new InputArgument('name', InputArgument::REQUIRED, 'The name'),
                new InputArgument('price', InputArgument::REQUIRED, 'The price'),
                new InputArgument('description', InputArgument::REQUIRED, 'The description'),
            ])
            ->setHelp(<<<EOT
The <info>fridge:plan:create</info> command creates a new subscription entity and persists it to stripe as a plan:

  <info>php app/console fridge:plan:create</info>

This interactive shell will guide you through the process.

EOT
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $subscriptionManager = $this->getContainer()->get('fridge.subscription.manager.subscription_manager');
            $subscription = $subscriptionManager->create();
            $subscription->setName($input->getArgument('name'));
            $subscription->setPrice($input->getArgument('price'));
            $subscription->setDescription($input->getArgument('description'));
            $subscriptionManager->save($subscription, true);
            $output->writeln('<info>Plan successfully created and persisted to Stripe</info>');
        }
        catch(\Exception $e) {
            $output->writeln('<error>Plan creation failed with the following error message: "'.$e->getMessage().'"</error>');
        }

    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('name')) {
            $name = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a name:',
                function($name) {
                    if (empty($name)) {
                        throw new \Exception('Name can not be empty');
                    }

                    return $name;
                }
            );
            $input->setArgument('name', $name);
        }

        if (!$input->getArgument('price')) {
            $price = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose an price:',
                function($price) {
                    if (empty($price)) {
                        throw new \Exception('Price can not be empty');
                    }

                    return $price;
                }
            );
            $input->setArgument('price', $price);
        }

        if (!$input->getArgument('description')) {
            $description = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a description:',
                function($description) {
                    if (empty($description)) {
                        throw new \Exception('Description can not be empty');
                    }

                    return $description;
                }
            );
            $input->setArgument('description', $description);
        }
    }
} 