<?php

namespace App\Controller;

use App\Service\FilmService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SerialController extends AbstractController
{
    #[Route('/serial', name: 'app_serial', methods: 'GET')]
    public function index(FilmService $serialService): Response
    {
        $serials = $serialService->getAllSerials();
        $serialAverageScore = [];

        foreach ($serials as $serial) {
            $serialAverageScore[$serial->getId()] = $serialService->getFilmAverageScore($serial);
        }

        return $this->render('serial/index.html.twig', [
            'serials' => $serials,
            'score' => $serialAverageScore
        ]);
    }

    #[Route('/serial/{id}', name: 'app_serial_serialDetails')]
    public function serialDetails(int $id, FilmService $serialService): Response
    {
        $serial = $serialService->getFilm($id);
        $serialAverageScore = $serialService->getFilmAverageScore($serial);

        return $this->render('serial/serial_details.html.twig', [
            'serial' => $serial,
            'score' => $serialAverageScore
        ]);
    }

    #[Route('/serial/{id}/addFavoriteFilm', name: 'app_serial_addFavoriteSerial', methods: 'POST')]
    public function addFavoriteFilm(int $id, UserService $userService, FilmService $filmService, Request $request): Response
    {
        $serial = $filmService->getFilm($id);
        if ($request->isMethod('POST')) {
            $userService->addFavoriteFilm($serial);
        }
        return $this->redirectToRoute('app_user');
    }

    #[Route('/serial/{id}/addFeedback', name: 'app_serial_addFeedback', methods: 'POST')]
    public function addFeedback(int $id, FilmService $filmService, Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $filmService->addFeedback($id, $data);
        }
        return $this->redirectToRoute('app_serial_serialDetails', ['id' => $id]);
    }
}
