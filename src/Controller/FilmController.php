<?php

namespace App\Controller;

use App\Service\FilmService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmController extends AbstractController
{
    #[Route('/film', name: 'app_film')]
    public function index(FilmService $film): Response
    {
        $films = $film->getAllFilms();
        return $this->render('film/index.html.twig', [
            'films' => $films
        ]);
    }
}
