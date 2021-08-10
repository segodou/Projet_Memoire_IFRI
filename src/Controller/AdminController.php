<?php

namespace App\Controller;

use App\Repository\AnnoncesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin_home")
     */
    public function dash(AnnoncesRepository $annonceRepository): Response
    {       
        $annonces = $annonceRepository->findBy(
            [   'statusAnnonce' => '0', 
                'sold' => '0'
            ], 
            ['createdAt' => 'DESC']
        );

        return $this->render('admin/index.html.twig', compact('annonces'));

    }

    /**
     * @Route("/admin/annonces", name="app_admin_annonces")
     */
    public function adminAnnonces(AnnoncesRepository $annonceRepository): Response
    {       
        $annonces = $annonceRepository->findBy(
            [   'statusAnnonce' => '0', 
                'sold' => '0'
            ], 
            ['createdAt' => 'DESC']
        );

        return $this->render('admin/accueil.html.twig', compact('annonces'));

    }
}
