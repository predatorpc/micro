<?php

namespace App\Rabbit;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

/**
* Class NotificationConsumer
*/
class RabbitListener implements ConsumerInterface
{
    /**
    * @var AMQPMessage $msg
    * @return void
    */

    public function execute(AMQPMessage $msg)
    {
        echo 'Полученны данные '.$msg->getBody().PHP_EOL.PHP_EOL;
    }
}

?>