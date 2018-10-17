<?php
/**
 * Created by PhpStorm.
 * User: merzlyakov.ms AKA predator_pc
 * Date: 15.10.2018
 * Time: 18:55
 */

namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class TestRabbitCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:test-rabbit')
            ->setDescription('Test for Rabbit')
            ->addArgument(
                'message',
                InputArgument::OPTIONAL,
                'Type the message please'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = $input->getArgument('message');

        if(!empty($message)) {
            $this->getContainer()
                ->get('old_sound_rabbit_mq.exchg_rabbit_producer')
                ->publish($message);
        }
        else{
            $this->getContainer()
                ->get('old_sound_rabbit_mq.exchg_rabbit_producer')
                ->publish('{empty_message}');
        }
    }

}