<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Repository\AnnoncesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnoncesController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(AnnoncesRepository $annonceRepository): Response
    {
        $annonces = $annonceRepository->findBy([], ['createdAt' => 'DESC']);
        return $this->render('annonces/index.html.twig', compact('annonces'));
    }

    /**
     * @Route("/annonces/create", name="app_annonces_create")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $annonce = new Annonces;
        $form = $this->createFormBuilder($annonce)
            ->add('title')
            ->add('description')
            ->add('price')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->getForm();
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($annonce);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }


        return $this->render('annonces/create.html.twig', [
            'monFormulaire' => $form->createView()
        ]);
    }


    /**
     * @Route("/annonces/{id<[0-9]+>}", name="app_annonces_show", methods="GET")
     */
    public function show(Annonces $annonce): Response
    {
        return $this->render('annonces/show.html.twig', compact('annonce'));
    }

    /**
     * @Route("/annonces/{id<[0-9]+>}/edit", name="app_annonces_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, EntityManagerInterface $em, Annonces $annonce): Response
    {
        $form = $this->createFormBuilder($annonce)
            ->add('title')
            ->add('description')
            ->add('price')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->getForm();
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_home');
        }


        return $this->render('annonces/edit.html.twig',  [
            'annonce' => $annonce,
            'monFormulaire' => $form->createView()
        ]);
    }
}
