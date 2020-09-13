<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecuriteController extends AbstractController
{

    /**
     * @Route("/inscription", name="securite.inscription")
     */
    public function inscription(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(InscriptionType::class, $utilisateur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $utilisateur->setPassword($encoder->encodePassword($utilisateur, $utilisateur->getPassword()));

            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute("securite.connexion");
        }

        return $this->render('securite/inscription.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="securite.connexion")
     */
    public function connexion(AuthenticationUtils $authenticationUtils)
    {
        $erreur = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('securite/connexion.html.twig', [
            'last_username' => $lastUsername,
            'erreur' => $erreur
        ]);
    }

    /**
     * @Route("/deconnexion", name="securite.deconnexion")
     */
    public function deconnexion()
    {
    }
}
