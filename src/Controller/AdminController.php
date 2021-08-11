<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Repository\AnnoncesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
                'sold' => false,
                'approved' => true,
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

        return $this->render('admin/indexAdmin.html.twig', [
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
                'sold' => false,
                'approved' => false,

            ], 
            ['createdAt' => 'DESC']
        );

        return $this->render('admin/accueil.html.twig', compact('annonces'));

    }

    /**
     * @Route("/admin/annonces/{id<[0-9]+>}", name="app_admin_annonces_show", methods="GET")
     */
    public function showAnnonces(Annonces $annonce): Response
    {
        return $this->render('admin/showAdmin.html.twig', compact('annonce'));
    }

     /**
     * @Route("/admin/annonces/{id<[0-9]+>}/edit", name="app_admin_annonces_edit", methods={"GET", "POST"})
     */
    public function approved(Request $request, EntityManagerInterface $em, Annonces $annonce): Response
    {
        if ($this->isCsrfTokenValid('approved' . $annonce->getId(), $request->request->get('_token'))) 
        {
            $annonce->setApproved(true);
            $em->persist($annonce);
            $em->flush();

            $this->addFlash('info', 'L\'annonce a été approuvé avec succès!');
        }

        return $this->redirectToRoute('app_admin_annonces');
    }

     /**
     * @Route("/admin/annonces/{id<[0-9]+>}/delete", name="app_admin_annonces_delete")
     */
    public function deleteAnnonces(Request $request, EntityManagerInterface $em, Annonces $annonce): Response
    {
       
        if ($this->isCsrfTokenValid('deletion' . $annonce->getId(), $request->request->get('_token'))) {
            $em->remove($annonce);
            $em->flush();

            $this->addFlash('info', 'L\'annonce est supprimée avec succès!');
       }

        return $this->redirectToRoute('app_admin_annonces');
    }
}
