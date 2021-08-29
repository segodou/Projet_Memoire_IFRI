<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\UserFormType;
use App\Repository\AnnoncesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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

        $annoncesAttente = $annonceRepository->findBy(
            [   'statusAnnonce' => '0', 
                'sold' => false,
                'approved' => false
            ]
        );

        $userAll = $userRepository->findBy(
            [   'isVerified' => true
            ]
        );

        $userMale = $userRepository->findBy(
            [   'isVerified' => true,
                'sexe' => 'M',
                'statusDelete' => false
            ]
        );

        $userFemale = $userRepository->findBy(
            [   'isVerified' => true,
                'sexe' => 'F',
                'statusDelete' => false
            ]
        );

        $userDelete = $userRepository->findBy(
            [   'isVerified' => true,
                'statusDelete' => true
            ]
        );

        return $this->render('admin/indexAdmin.html.twig', [
            'annonces' => $annonces,
            'userAll' => $userAll,
            'userMale' => $userMale,
            'userFemale' => $userFemale,
            'userDelete' => $userDelete,
            'annoncesAttente' => $annoncesAttente
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

        return $this->render('admin/attente.html.twig', compact('annonces'));

    }

    /**
     * @Route("/admin/annonces/{id<[0-9]+>}", name="app_admin_annonces_show", methods="GET")
     */
    public function showAnnonces(Annonces $annonce): Response
    {
        return $this->render('admin/showAttente.html.twig', compact('annonce'));
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

    /**
     * @Route("/admin/account", name="app_admin_account")
     * 
     */
    public function showAccount(): Response
    {
        return $this->render('admin/showAccount.html.twig');
    }

    /**
     * @Route("/admin/account/edit", name="app_admin_account_edit")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        
        $user = $this->getUser();
        
        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Votre profil a été mis à jour avec succès');

            return $this->redirectToRoute('app_admin_home');
        }

        return $this->render('admin/editAdmin.html.twig', [
            'Form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/admin/account/change-password", name="app_admin_account_change_password")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function changePassword(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasherPassword): Response
    {
        
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordFormType::class, null, [
            'current_password_is_required' => true
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $hasherPassword->hashPassword($user, $form['plainPassword']->getData())
            );

            $em->flush();

            $this->addFlash('success', 'Votre mot de passe a été mis à jour avec succès');

            return $this->redirectToRoute('app_admin_account');

        }


        return $this->render('admin/change_password.html.twig', [
            'Form'=> $form->createView()
        ]);
    }
}
