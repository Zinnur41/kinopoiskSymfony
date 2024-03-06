<?php

namespace App\Controller;

use App\Form\FavoriteFilmFormType;
use App\Service\FilmService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SerialController extends AbstractController
{
    #[Route('/serial', name: 'app_serial', methods: 'GET')]
    public function index(FilmService $serial): Response
    {
        $serials = $serial->getAllSerials();
        return $this->render('serial/index.html.twig', [
            'serials' => $serials
        ]);
    }

    #[Route('/serial/{id}', name: 'app_serial_serialDetails')]
    public function serialDetails(int $id, FilmService $serial, UserService $userService, Request $request): Response
    {
        $serial = $serial->getFilm($id);

        if ($request->isMethod('POST')) {
            $userService->addFavoriteFilm($serial);
            return $this->redirectToRoute('app_serial_serialDetails', ['id' => $id]);
        }

        return $this->render('serial/serial_details.html.twig', [
            'serial' => $serial
        ]);
    }
}
