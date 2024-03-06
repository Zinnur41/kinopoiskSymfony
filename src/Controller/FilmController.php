<?php

namespace App\Controller;

use App\Form\FavoriteFilmFormType;
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
    public function filmDetails(int $id, FilmService $film, UserService $userService, Request $request): Response
    {
        $film = $film->getFilm($id);

        if ($request->isMethod('POST')) {
            $userService->addFavoriteFilm($film);
            return $this->redirectToRoute('app_film_filmDetails', ['id' => $id]);
        }

        return $this->render('film/film_details.html.twig', [
            'film' => $film
        ]);
    }
}
