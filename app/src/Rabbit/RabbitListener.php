<?php

namespace App\Rabbit;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/*
*
* Class NotificationConsumer
*
*/

class RabbitListener implements ConsumerInterface
{
    /**
    * @var AMQPMessage $msg
    * @return void
    */

    public $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(AMQPMessage $msg)
    {

        // create a log channel
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler('app/log/debug.log', Logger::DEBUG));
        $log->debug($msg->getBody());
        echo 'Полученны данные '.$msg->getBody().PHP_EOL.PHP_EOL;

        $this->logger->debug($msg->getBody());

    }
}

?>