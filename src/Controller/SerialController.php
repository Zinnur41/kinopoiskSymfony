<?php

namespace App\Controller;

use App\Service\FilmService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SerialController extends AbstractController
{
    #[Route('/serial', name: 'app_serial')]
    public function index(FilmService $serial): Response
    {
        $serials = $serial->getAllSerials();
        return $this->render('serial/index.html.twig', [
            'serials' => $serials
        ]);
    }
}
