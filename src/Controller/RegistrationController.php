<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Service\MailerService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'app_registration')]
    public function index(Request $request, MailerService $mailer): Response
    {
        $form = $this->createForm(RegistrationFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            try {
                $code = rand(1000, 9999);
                setcookie('emailCode', $code);
                setcookie('formData', serialize($data));
                $mailer->sendMail($form->get('email')->getData(), $code);
                return $this->redirectToRoute('app_registration_userConfirmation');
            } catch (TransportExceptionInterface) {
                return $this->redirectToRoute('app_registration');
            }
        }
        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/registration/confirmPage', name: 'app_registration_userConfirmation')]
    public function userConfirmation(Request $request, UserService $userService): Response
    {
        if ($request->getMethod() === 'GET') {
            return $this->render('mailer/confirmPage.html.twig');
        } else {
            $emailCode = $_COOKIE['emailCode'];
            $userCode = $request->request->get('userCode');

            if ($emailCode !== $userCode) {
                setcookie('emailCode', '', time() - 3600);
                setcookie('formData', '', time() - 3600);
                return $this->redirectToRoute('app_registration');
            } else {
                $data = unserialize($_COOKIE['formData']);
                $userService->addUser($data);
                setcookie('emailCode', '', time() - 3600);
                setcookie('formData', '', time() - 3600);
                return $this->redirectToRoute('app_login');
            }
        }
    }
}
