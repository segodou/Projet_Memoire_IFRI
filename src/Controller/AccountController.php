<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/account")
 */
class AccountController extends AbstractController
{
    /**
     * @Route("", name="app_account")
     * @IsGranted("ROLE_USER")
     */
    public function show(): Response
    {

        return $this->render('account/show.html.twig');
    }

    /**
     * @Route("/edit", name="app_account_edit")
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

            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/edit.html.twig', [
            'Form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/change-password", name="app_account_change_password")
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

            return $this->redirectToRoute('app_account');

        }


        return $this->render('account/change_password.html.twig', [
            'Form'=> $form->createView()
        ]);
    }
}
