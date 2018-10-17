<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class SiteController extends AbstractController
{
    /**
     * @Route("/site/index", name="index")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SiteController.php',
        ]);
    }

    /**
     * @Route("/site/site", name="site")
     */
    public function site()
    {
        return $this->json([
            'message' => 'SITE: Welcome to your new controller!',
            'path' => 'src/Controller/SiteController.php',
        ]);
    }
}
