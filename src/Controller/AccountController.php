<?php

namespace App\Controller;

use App\Form\UserProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/account/profile", name="account_profile")
     * Autoriser l'accès uniquement aux utilisateurs connectés
     * @IsGranted("ROLE_USER")
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {
        // Récupérer l'utilisateur actuel: $this->getUser()
        // Associer le formulaire à l'utilisateur actuel: $this->createForm(Form::class, $this->getUser())

        $form = $this->createForm(UserProfileFormType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Il n'est pas nécessaire d'appeler persist() pour modifier des entités
            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a été mis à jour.');
        }

        return $this->render('account/profile.html.twig', [
            'profile_form' => $form->createView()
        ]);
    }
}