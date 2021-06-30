<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Repository\AnnoncesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnoncesController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(AnnoncesRepository $annonceRepository): Response
    {
        $annonces = $annonceRepository->findAll();
        return $this->render('annonces/index.html.twig', compact('annonces'));
    }

    /**
     * @Route("/annonces/{id<[0-9]+>}", name="app_annonces_show")
     */
    public function show(Annonces $annonce): Response
    {
        return $this->render('annonces/show.html.twig', compact('annonce'));
    }
}
