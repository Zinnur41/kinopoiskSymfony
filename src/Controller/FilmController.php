<?php

namespace App\Controller;

use App\Service\FilmService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/film/{id}', name: 'app_film_filmDetails', methods: 'GET')]
    public function filmDetails(int $id, FilmService $film): Response
    {
        $film = $film->getFilm($id);
        return $this->render('film/film_details.html.twig', [
            'film' => $film
        ]);
    }
}
