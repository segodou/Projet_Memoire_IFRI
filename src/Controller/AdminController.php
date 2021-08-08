<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function dash(): Response
    {
            $this->denyAccessUnlessGranted('ROLE_AMDIN');

            return $this->render('admin/accueil.html.twig');

    }
}
