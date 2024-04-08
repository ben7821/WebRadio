<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Form\ChangePasswordType;

///////////////////////////////////////////////
/// UtilisateurController
/// Gestion des utilisateurs
///////////////////////////////////////////////
#[Route('/admin/utilisateur')]
class UtilisateurController extends AbstractController
{

    /// ------------------------------------------
    /// register
    /// Création d'un utilisateur
    /// ------------------------------------------
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userData = $form->getData();

            // recup les roles
            $roles = $request->request->all("registration_form")['roles'];

            $user->setRoles([$roles]);

            // hash le password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $userData->getPassword()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // lancer l'auth
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('utilisateur/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /// ------------------------------------------
    /// update
    /// Mise à jour d'un utilisateur (mot de passe)
    /// ------------------------------------------
    #[Route('/update/{id}', name: 'app_utilisateur_update', methods: ['GET', 'POST'])]
    public function update(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $form = $this->createForm(ChangePasswordType::class, $utilisateur, ['admin' => $this->isGranted('ROLE_ADMIN')]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userData = $form->getData();

            // recup les password
            $news = $request->request->all("change_password");

            // si le password actuel est bon
            if ($passwordEncoder->isPasswordValid($utilisateur, $news['password'])) {

                // si les 2 nouveaux password sont identiques
                if ($news['newPassword']['first'] === $news['newPassword']['second']) {

                    // hash le nouveau password
                    $utilisateur->setPassword(
                        $passwordEncoder->hashPassword(
                            $utilisateur,
                            $news['newPassword']['first']
                        )
                    );
                }
            }

            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('app_creation', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('utilisateur/update.html.twig', [
            'form' => $form->createView(),
            'admin' => true,
        ]);
    }

    /// ------------------------------------------
    /// delete
    /// Suppression d'un utilisateur
    /// ------------------------------------------
    #[Route('/delete/{id}', name: 'app_utilisateur_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $utilisateur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($utilisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_creation', [], Response::HTTP_SEE_OTHER);
    }
}
