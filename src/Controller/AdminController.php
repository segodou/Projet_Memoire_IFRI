<?php

namespace App\Controller;

use App\Repository\AnnoncesRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin_home")
     */
    public function dash(AnnoncesRepository $annonceRepository, UserRepository $userRepository): Response
    {       
        $annonces = $annonceRepository->findBy(
            [   'statusAnnonce' => '0', 
                'sold' => '0'
            ], 
            ['createdAt' => 'DESC']
        );

        $userAll = $userRepository->findBy(
            [   'isVerified' => true
            ]
        );

        $userMale = $userRepository->findBy(
            [   'isVerified' => true,
                'sexe' => 'M'
            ]
        );

        $userFemale = $userRepository->findBy(
            [   'isVerified' => true,
                'sexe' => 'F'
            ]
        );

        return $this->render('admin/index.html.twig', [
            'annonces' => $annonces,
            'userAll' => $userAll,
            'userMale' => $userMale,
            'userFemale' => $userFemale
        ]);

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
