<?php

namespace App\Controller;

use App\Form\FilmFormType;
use App\Service\FilmService;
use App\Service\SiteFeedbackService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/users', name: 'app_admin_getUsers', methods: 'GET')]
    public function getUsers(UserService $userService): Response
    {
        $users = $userService->getAllUsers();
        return $this->render('admin/users.html.twig', [
            'users' => $users
        ]);
    }
    #[Route('/admin/deleteUser/{id}', name: 'app_admin_deleteUser', methods: 'POST')]
    public function deleteUser(UserService $userService, $id): Response
    {
        $userService->deleteUser($id);
        return $this->redirectToRoute('app_admin_getUsers');
    }

    #[Route('/admin/film', name: 'app_admin_addFilm')]
    public function addFilm(FilmService $film, Request $request): Response
    {
        $form = $this->createForm(FilmFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            $genre = $form->get('genre')->getData();
            $data = $form->getData();

            if ($imageFile) {
                $imageName = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('filmImagesDirectory'),
                    $imageName
                );
                $film->addFilm($data, $imageName, $genre);
                return $this->redirectToRoute('app_admin_addFilm');
             }
        }

        $films = $film->getAllFilms();
        return $this->render('admin/film/films.html.twig', [
            'films' => $films,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/film/{id}', name: 'app_admin_filmDetails', methods: 'GET')]
    public function filmDetails(int $id, FilmService $filmService): Response
    {
        $film = $filmService->getFilm($id);

        return $this->render('admin/film/film_details.html.twig', [
            'film' => $film
        ]);
    }

    #[Route('/admin/serial/{id}', name: 'app_admin_serialDetails', methods: 'GET')]
    public function serialDetails(int $id, FilmService $filmService): Response
    {
        $serial = $filmService->getFilm($id);

        return $this->render('admin/serial/serial_details.html.twig', [
            'serial' => $serial
        ]);
    }

    #[Route('/admin/serial', name: 'app_admin_addSerial')]
    public function addSerial(FilmService $serial, Request $request): Response
    {
        $form = $this->createForm(FilmFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $imageFile = $form->get('image')->getData();
            $genre = $form->get('genre')->getData();

            if($imageFile) {
                $imageName = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('serialImagesDirectory'),
                    $imageName
                );
                $serial->addSerial($data, $imageName, $genre);
                return $this->redirectToRoute('app_admin_addSerial');
            }
        }

        $serials = $serial->getAllSerials();
        return $this->render('admin/serial/serials.html.twig', [
            'serials' => $serials,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/film/{id}/delete', name: 'app_admin_deleteFilm', methods: 'POST')]
    public function deleteFilm(FilmService $film, int $id): Response
    {
        $film->deleteFilmOrSerial($id);
        return $this->redirectToRoute('app_admin_addFilm');
    }

    #[Route('/admin/serial/{id}/delete', name: 'app_admin_deleteSerial', methods: 'POST')]
    public function deleteSerial(FilmService $film, int $id): Response
    {
        $film->deleteFilmOrSerial($id);
        return $this->redirectToRoute('app_admin_addSerial');
    }


    #[Route('/admin/siteFeedback', name: 'app_admin_getSiteFeedbacks', methods: 'GET')]
    public function getSiteFeedbacks(SiteFeedbackService $feedbackService): Response
    {
        $averageScore = $feedbackService->getAverageScore();

        $feedbacks = $feedbackService->getAllSiteFeedback();

        return $this->render('admin/siteFeedback.html.twig', [
            'feedbacks' => $feedbacks,
            'averageScore' => $averageScore
        ]);
    }

    #[Route('/admin/siteFeedback/delete/{id}')]
    public function deleteSiteFeedback(SiteFeedbackService $feedbackService, int $id): Response
    {
        $feedbackService->deleteSiteFeedback($id);

        return $this->redirectToRoute('app_admin_getSiteFeedbacks');
    }
}
