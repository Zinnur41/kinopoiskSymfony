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
    public function index(FilmService $film): Response
    {
        $films = $film->getAllFilms();
        return $this->render('film/index.html.twig', [
            'films' => $films
        ]);
    }

    #[Route('/film/{id}', name: 'app_film_filmDetails')]
    public function filmDetails(int $id, FilmService $filmService, UserService $userService, Request $request): Response
    {
        $film = $filmService->getFilm($id);

        if ($request->isMethod('POST')) {
            $userService->addFavoriteFilm($film);
            return $this->redirectToRoute('app_user');
        }

        return $this->render('film/film_details.html.twig', [
            'film' => $film
        ]);
    }
}
