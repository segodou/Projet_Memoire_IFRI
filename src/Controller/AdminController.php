<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Entity\User;
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
                'approved' => '0',

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
     * @Route("/admin/annonces/{id<[0-9]+>}/simple", name="app_admin_annonces_sh", methods="GET")
     */
    public function show(Annonces $annonce): Response
    {
        return $this->render('admin/showAd.html.twig', compact('annonce'));
    }

     /**
     * @Route("/admin/annonces/{id<[0-9]+>}/approved", name="app_admin_annonces_approved", methods={"GET", "POST"})
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
            $em->remove($annonce->getMarket());
            $em->remove($annonce->getHopital());
            $em->remove($annonce->getSchool());
            $em->remove($annonce->getSuperMarket());
            $em->remove($annonce->getRestaurant());
            $em->flush();

            $this->addFlash('info', 'L\'annonce est supprimée avec succès!');
       }

        return $this->redirectToRoute('app_admin_annonces');
    }

    /**
     * @Route("/admin/users", name="app_admin_users")
     */
    public function tableUsers(UserRepository $userRepository): Response
    {       
        $users = $userRepository->findBy(
            [   'isVerified' => true,
                'statusDelete' => false, 
            ], 
            ['createdAt' => 'DESC']
        );

        return $this->render('admin/users.html.twig', compact('users'));

    }

    /**
     * @Route("/admin/user/{id<[0-9]+>}/delete", name="app_admin_user_delete")
     */
    public function deleteUser(Request $request, EntityManagerInterface $em, User $user): Response
    {
       
        if ($this->isCsrfTokenValid('deletion' . $user->getId(), $request->request->get('_token'))) {
            $user->setStatusDelete(true);
            $em->persist($user);
            $em->flush();

            $this->addFlash('info', 'L\'utilisateur est supprimée avec succès!');
       }

        return $this->redirectToRoute('app_admin_users');
    }

    /**
     * @Route("/admin/user/show/{id<[0-9]+>}", name="app_admin_user_show")
     */
    public function showUser(User $user): Response
    {

        return $this->render('admin/showUser.html.twig', compact('user'));
    }
}
