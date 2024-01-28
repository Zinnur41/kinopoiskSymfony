<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }
    #[Route('/admin/users', name: 'app_admin_getUsers')]
    public function getUsers(UserService $userService): Response
    {
        $users = $userService->getAllUsers();
        return $this->render('admin/users.html.twig', [
            'users' => $users
        ]);
    }
    #[Route('/admin/deleteUser/{id}', name: 'app_admin_deleteUser')]
    public function deleteUser(UserService $userService, $id)
    {
        $userService->deleteUser($id);
        return $this->redirectToRoute('app_admin_getUsers');
    }
}
