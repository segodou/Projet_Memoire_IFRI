<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashController extends AbstractController
{
    /**
     * @Route("/dash", name="dash")
     */
    public function dash(): Response
    {       
        return $this->render('dashboard/index.html.twig');

    }

    /**
     * @Route("/dash/layout", name="dash_layout")
     */
    public function layout(): Response
    {       
        return $this->render('dashboard/table.html.twig');

    }
}
