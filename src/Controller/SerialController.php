<?php

namespace App\Controller;

use App\Form\FeedbackFormType;
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
    public function serialDetails(int $id, FilmService $serialService, UserService $userService, Request $request): Response
    {
        $serial = $serialService->getFilm($id);
        $serialAverageScore = $serialService->getFilmAverageScore($serial);

        if ($request->isMethod('POST') && $request->request->has('addFavoriteFilm')) {
            $userService->addFavoriteFilm($serial);
            return $this->redirectToRoute('app_user');
        }

        if ($request->isMethod('POST') && $request->request->has('feedback')) {
            $data = $request->request->all();
            $serialService->addFeedback($id, $data);
            return $this->redirectToRoute('app_serial_serialDetails', ['id' => $id]);
        }

        return $this->render('serial/serial_details.html.twig', [
            'serial' => $serial,
            'score' => $serialAverageScore
        ]);
    }
}
