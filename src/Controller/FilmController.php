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
    public function filmDetails(int $id, FilmService $filmService, UserService $userService, Request $request): Response
    {
        $film = $filmService->getFilm($id);
        $filmAverageScore = $filmService->getFilmAverageScore($film);

        if ($request->isMethod('POST') && $request->request->has('addFavoriteFilm')) {
            $userService->addFavoriteFilm($film);
            return $this->redirectToRoute('app_user');
        }

        if ($request->isMethod('POST') && $request->request->has('feedback') ) {
            $data = $request->request->all();
            $filmService->addFeedback($id, $data);
            return $this->redirectToRoute('app_film_filmDetails', ['id' => $id]);
        }

        return $this->render('film/film_details.html.twig', [
            'film' => $film,
            'score' => $filmAverageScore
        ]);
    }
}
