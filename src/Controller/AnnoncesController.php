<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Entity\Hopital;
use App\Entity\Images;
use App\Entity\Market;
use App\Entity\Restaurant;
use App\Entity\School;
use App\Entity\SuperMarket;
use App\Form\AnnoncesType;
use App\Repository\AnnoncesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AnnoncesController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(AnnoncesRepository $annonceRepository): Response
    {
        $annonces = $annonceRepository->findBy(
                    [   'statusAnnonce' => '0', 
                        'sold' => '0'
                    ], 
                    ['createdAt' => 'DESC']
                );
        return $this->render('annonces/index.html.twig', compact('annonces'));
    }

    /**
     * @Route("/annonces/user", name="app_annonces_user")
     */
    public function annoncesUser(AnnoncesRepository $annonceRepository): Response
    {
        $user = $this->getUser()->getId();
        $annonces = $annonceRepository->findBy(
                    [   'user' => $user], 
                    ['createdAt' => 'DESC']
                );
        return $this->render('annonces/annonceUser.html.twig', compact('annonces'));
    }

    /**
     * @Route("/annonces/create", name="app_annonces_create")
     * @Security("is_granted('ROLE_USER') && user.isVerified()")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        
        $annonce = new Annonces;
        $form = $this->createForm(AnnoncesType::class, $annonce);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonce->setStatusAnnonce("0");

             //on enregistre les données concernant le marché
            $market = new Market;
            $market->setTitleM($form->get('titleM')->getData());
            $market->setAdresseM($form->get('adresseM')->getData());
            $market->setDescriptionM($form->get('descriptionM')->getData());

             //on enregistre les données concernant le supermarché
            $superMarket = new SuperMarket;
            $superMarket->setTitleSM($form->get('titleSM')->getData());
            $superMarket->setAdresseSM($form->get('adresseSM')->getData());
            $superMarket->setDescriptionSM($form->get('descriptionSM')->getData());

            //on enregistre les données concernant l'hopital
            $hopital = new Hopital;
            $hopital->setTitleH($form->get('titleH')->getData());
            $hopital->setAdresseH($form->get('adresseH')->getData());
            $hopital->setDescriptionH($form->get('descriptionH')->getData());

            //on enregistre les données concernant l'école
            $school = new School;
            $school->setTitleS($form->get('titleS')->getData());
            $school->setAdresseS($form->get('adresseS')->getData());
            $school->setDescriptionS($form->get('descriptionS')->getData());

            //on enregistre les données concernant l'école
            $restaurant = new Restaurant;
            $restaurant->setTitleR($form->get('titleR')->getData());
            $restaurant->setAdresseR($form->get('adresseR')->getData());
            $restaurant->setDescriptionR($form->get('descriptionR')->getData());

             // On récupère les images transmises
             $images = $form->get('images')->getData();

             // On boucle sur les images
             foreach($images as $image){
                 // On génère un nouveau nom de fichier
                 $fichier = md5(uniqid()) . '.' . $image->guessExtension();
 
                 // On copie le fichier dans le dossier uploads
                 $image->move(
                     $this->getParameter('images_directory'),
                     $fichier
                 );
 
                 // On stocke l'image dans la base de données (son nom)
                 $img = new Images();
                 $img->setName($fichier);
                 $annonce->addImage($img);
             }
 
            $em = $this->getDoctrine()->getManager();
            $annonce->setUser($this->getUser());
            $annonce->setMarket($market);
            $annonce->setSuperMarket($superMarket);
            $annonce->setHopital($hopital);
            $annonce->setSchool($school);
            $annonce->setRestaurant($restaurant);
            $em->persist($annonce);
            $em->flush();

            $this->addFlash('success', 'L\'annonce est créé avec succès!');

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
     * @Security("is_granted('ROLE_USER') && user.isVerified() && annonce.getUser() == user")
     */
    public function edit(Request $request, EntityManagerInterface $em, Annonces $annonce): Response
    {
        $form = $this->createForm(AnnoncesType::class, $annonce);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $images = $form->get('images')->getData();

            // On boucle sur les images
            foreach($images as $image){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // On stocke l'image dans la base de données (son nom)
                $img = new Images();
                $img->setName($fichier);
                $annonce->addImage($img);
            }

            $em->flush();

            $this->addFlash('success', 'L\'annonce est modifiée avec succès!');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('annonces/edit.html.twig',  [
            'annonce' => $annonce,
            'monFormulaire' => $form->createView()
        ]);
    }

    /**
     * @Route("/annonces/{id<[0-9]+>}/delete", name="app_annonces_delete")
     * @Security("is_granted('ROLE_USER') && user.isVerified() && annonce.getUser() == user")
     */
    public function delete(Request $request, EntityManagerInterface $em, Annonces $annonce): Response
    {
       
        if ($this->isCsrfTokenValid('deletion' . $annonce->getId(), $request->request->get('_token'))) {
            $annonce->setStatusAnnonce("1");
            $em->persist($annonce);
            $em->flush();

            $this->addFlash('info', 'L\'annonce est supprimée avec succès!');
       }

        return $this->redirectToRoute('app_home');
    }

    /**
     * @Route("/supprime/image/{id}", name="annonces_delete_image", methods={"DELETE"})
     */
    public function deleteImage(Images $image, Request $request): Response
    {

        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){
            // On récupère le nom de l'image
            $nom = $image->getName();
            // On supprime le fichier
            unlink($this->getParameter('images_directory').'/'.$nom);

            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }

    /**
     * @Route("/caroussel", name="caroussel")
     */
    public function carousel(): Response
    {
        return $this->render('annonces/carou.html.twig');
    }
}
