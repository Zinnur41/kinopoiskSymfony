<?php

namespace App\Controller;

use App\Service\FilmService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmController extends AbstractController
{
    #[Route('/film', name: 'app_film', methods: 'GET')]
    public function index(FilmService $filmService): Response
    {
        $films = $filmService->getAllFilms();
        $filmAverageScore = [];

        foreach ($films as $film) {
            $filmAverageScore[$film->getId()] = $filmService->getFilmAverageScore($film);
        }

        return $this->render('film/index.html.twig', [
            'films' => $films,
            'score' => $filmAverageScore
        ]);
    }

    #[Route('/film/{id}', name: 'app_film_filmDetails')]
    public function filmDetails(int $id, FilmService $filmService): Response
    {
        $film = $filmService->getFilm($id);
        $filmAverageScore = $filmService->getFilmAverageScore($film);

        return $this->render('film/film_details.html.twig', [
            'film' => $film,
            'score' => $filmAverageScore
        ]);
    }

    #[Route('/film/{id}/addFavoriteFilm', name: 'app_film_addFavoriteFilm', methods: 'POST')]
    public function addFavoriteFilm(int $id, UserService $userService, FilmService $filmService, Request $request): Response
    {
        $film = $filmService->getFilm($id);
        if ($request->isMethod('POST')) {
            $userService->addFavoriteFilm($film);
        }
        return $this->redirectToRoute('app_user');
    }

    #[Route('/film/{id}/addFeedback', name: 'app_film_addFeedback', methods: 'POST')]
    public function addFeedback(int $id, FilmService $filmService, Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $filmService->addFeedback($id, $data);
        }
        return $this->redirectToRoute('app_film_filmDetails', ['id' => $id]);
    }
}
