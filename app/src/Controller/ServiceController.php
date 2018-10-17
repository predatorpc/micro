<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Process\Process;
use App\Entity\DaemonManager;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service/consumer")
     */

    public function consumer()
    {
        $process = new Process('php /var/www/app/bin/console rabbitmq:consumer exchg_rabbit > /dev/null 2>&1 &', '/var/www/app/');
        $process->start();

        if(!empty($process->getPid())) {
            return new Response( "Instance started successfull<br> 
                                 <a href=/service/manager/>Return to Manager</a>");
        }
        else {
            return new Response( "Instance execution error<br> 
                                  <a href=/service/manager/>Return to Manager</a>");
        }

    }

    /**
     * @Route("/service/manager")
     *
     * @Route("/service")
     */

    public function manager()
    {
        $daemons = $this->getDoctrine()->getRepository(DaemonManager::class);
        $daemonsList = $daemons->findBy(['status' => 1]);

        echo "<b>Active Consumers list</b><br>";



        if(!empty($daemonsList)) {
            echo "PID Action<br>";
            foreach ($daemonsList as $item) {
                echo $item->getPid() . " <a href=/service/kill/" . $item->getPid() . ">Kill</a><br> ";
            }
            echo "<a href=/service/consumer>Start new instance</a><br>";
        }
        else {
            echo "It seems there is no active Consumers<br>";
            echo "<a href=/service/consumer>Start new instance</a><br>";

        }

        die();
    }

    /**
     * @Route("/service/kill/{pid}")
     */

    public function kill($pid)
    {
        $daemons = $this->getDoctrine()->getRepository(DaemonManager::class);
        $daemon = $daemons->findOneBy(['pid' => $pid]);

        if (!empty($daemon) && $daemon->getStatus()==1) {

            if (posix_kill($pid, 9)) {
                echo "Process with PID " . $pid . " successfully killed.<br>";
                echo "<a href=/service/manager/>Return to Manager</a>";

                $em = $this->getDoctrine()->getManager();
                $em->remove($daemon);
                $em->flush();
            }
            else {
                echo "Kill failed<br>";
                echo "<a href=/service/manager/>Return to Manager</a>";
            }
        }
        else {
            echo "No records regarding this process in DB, or it's already been killed<br>";
            echo "<a href=/service/manager/>Return to Manager</a>";
        }

        die();
    }
}
