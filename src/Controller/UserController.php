<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user', methods: 'GET')]
    public function index(UserService $userService): Response
    {
        $user = $userService->getActiveUser();
        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/deleteFavoriteFilm/{id}', name: 'app_user_deleteFavoriteFilm', methods: 'POST')]
    public function deleteFavoriteFilm(UserService $userService, int $id): Response
    {
        $userService->deleteFavoriteFilm($id);
        return $this->redirectToRoute('app_user');
    }

    #[Route('/user/review/{id}/delete', name: 'app_user_deleteReview', methods: 'POST')]
    public function deleteReview(UserService $userService, int $id): Response
    {
        $userService->deleteReview($id);
        return $this->redirectToRoute('app_user');
    }

    #[Route('/user/addSubscribe', name: 'app_user_addSubscribe', methods: 'POST')]
    public function addSubscribe(Request $request, UserService $userService): Response
    {
        if ($request->isMethod('POST')) {
            $days = $request->request->get('days');
            $userService->addSubscription($days);
        }
        return $this->redirectToRoute('app_user');
    }
}
