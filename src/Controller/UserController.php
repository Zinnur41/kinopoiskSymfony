<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route(name: 'app_user', methods: 'GET')]
    public function index(UserService $userService): Response
    {
        $user = $userService->getActiveUser();
        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/deleteFavoriteFilm/{id}', name: 'app_user_deleteFavoriteFilm', methods: 'POST')]
    public function deleteFavoriteFilm(UserService $userService, int $id): Response
    {
        $userService->deleteFavoriteFilm($id);
        return $this->redirectToRoute('app_user');
    }

    #[Route('/review/{id}/delete', name: 'app_user_deleteReview', methods: 'POST')]
    public function deleteReview(UserService $userService, int $id): Response
    {
        $userService->deleteReview($id);
        return $this->redirectToRoute('app_user');
    }

    #[Route('/addSubscribe', name: 'app_user_addSubscribe', methods: 'POST')]
    public function addSubscribe(Request $request, UserService $userService): Response
    {
        if ($request->isMethod('POST')) {
            $days = $request->request->get('days');
            $userService->addSubscription($days);
        }
        return $this->redirectToRoute('app_user');
    }

    #[Route('/deleteSubscribe', name: 'app_user_deleteSubscribe', methods: 'POST')]
    public function deleteSubscribe(UserService $userService): Response
    {
        $userService->deleteSubscription();
        return $this->redirectToRoute('app_user');
    }

    #[Route('/update', name: 'app_user_updateUser')]
    public function updateUser(UserService $userService, Request $request): Response
    {
        $user = $userService->getActiveUser();
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('photo')->getData();
            if ($photo) {
                $photoPath = uniqid() . '.' . $photo->guessExtension();
                $photo->move(
                    $this->getParameter('userPhotosDirectory'),
                    $photoPath
                );
                $userService->updateUser($user, $photoPath);
                return $this->redirectToRoute('app_user');
            }
        }
        return $this->render('user/update.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
