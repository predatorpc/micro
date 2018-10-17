<?php

namespace App\Rabbit;

use App\Entity\DaemonManager;
use Doctrine\ORM\EntityManagerInterface;
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

//    public $logger;
//    private $em;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $em)
    {
//        $this->logger = $logger;
        $log = new Logger('pid');
        $log->pushHandler(new StreamHandler('var/log/own.log', Logger::DEBUG));
        $log->debug(getmypid());

        //adding record
        $daemon = new DaemonManager();
        $daemon->setPid(getmypid());
        $daemon->setStatus(1);
        $em->persist($daemon);
        $em->flush();
    }

    public function execute(AMQPMessage $msg)
    {
        // create a log channel
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler('var/log/own.log', Logger::DEBUG));
        $log->debug($msg->getBody()." [PID] ".getmypid());

//        echo 'Полученны данные '.$msg->getBody().PHP_EOL.PHP_EOL;
//        $this->logger->debug($msg-

    }
}

?>