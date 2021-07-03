<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Form\AnnoncesType;
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
        $annonces = $annonceRepository->findBy(
                    ['statusAnnonce' => '0'], 
                    ['createdAt' => 'DESC']
                );
        return $this->render('annonces/index.html.twig', compact('annonces'));
    }

    /**
     * @Route("/annonces/create", name="app_annonces_create")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $annonce = new Annonces;
        $form = $this->createForm(AnnoncesType::class, $annonce);

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
        $form = $this->createForm(AnnoncesType::class, $annonce);

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

    /**
     * @Route("/annonces/{id<[0-9]+>}/delete", name="app_annonces_delete")
     */
    public function delete(Request $request, EntityManagerInterface $em, Annonces $annonce): Response
    {   
       if ($this->isCsrfTokenValid('deletion' . $annonce->getId(), $request->request->get('_token'))) {
            $annonce->setStatusAnnonce("1");
            $em->persist($annonce);
            $em->flush();
       }

        return $this->redirectToRoute('app_home');
    }
}
