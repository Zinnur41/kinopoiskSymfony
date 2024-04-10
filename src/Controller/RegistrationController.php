<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'app_registration')]
    public function index(Request $request, UserService $userService, MailerInterface $mailer): Response
    {
        $form = $this->createForm(RegistrationFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            try {
                $email = (new Email())
                    ->from('zagidullin_zin@mail.ru')
                    ->to($data['email'])
                    ->subject('Подтверждение регистрации')
                    ->text('Ваш код для создания аккаунта: ' . rand(1000, 9999));
                $mailer->send($email);
                $userService->addUser($data);
            } catch (TransportExceptionInterface) {
                return $this->redirectToRoute('app_registration');
            }
            return $this->redirectToRoute('app_login');
        }
        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
