<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Form\EmailFormType;


///////////////////////////////////////////////
/// EmailController
/// Contrôleur pour la page de contact
///////////////////////////////////////////////
class EmailController extends AbstractController
{

    /// ------------------------------------------
    /// sendEmail
    /// Envoie un e-mail à l'administrateur
    /// ------------------------------------------
    #[Route('/admin/mail', name: 'app_mail')]
    public function sendEmail(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(EmailFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Construire le corps de l'e-mail avec les données du formulaire
            $emailBody = sprintf(
                "Nom: %s\nEmail: %s\nMessage: %s",
                $data['name'],
                $data['email'],
                $data['message']
            );
            
            // Envoyer l'e-mail
            $email = (new Email())
                ->from($data['email'])
                ->to('report.webradio@gmail.com')
                ->subject('Rapport du '.  date('Y-m-d H:i:s'))
                ->text($emailBody);

            $mailer->send($email);
                // Rediriger vers une nouvelle page de confirmation
                return $this->render('email/confirmation.html.twig', [
                    'message' => 'Merci pour votre message. Nous vous contacterons bientôt!',
                    'requestData' => $data,
                    'test'=>$email,
                ]);
            }

        return $this->render('email/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}