<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user', methods: 'GET')]
    public function index(UserService $userService): Response
    {
        $user = $userService->getActiveUser();
        return $this->render('user/index.html.twig', [
            'user' => $user
        ]);
    }
}
