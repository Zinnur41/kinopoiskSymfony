<?php

namespace App\Controller;

use App\Form\SiteFeedbackFormType;
use App\Service\SiteFeedbackService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteFeedbackController extends AbstractController
{
    #[Route('/siteFeedback', name: 'app_feedback')]
    public function index(SiteFeedbackService $siteFeedbackService, Request $request): Response
    {
        $averageScore = $siteFeedbackService->getAverageScore();

        $form = $this->createForm(SiteFeedbackFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $siteFeedbackService->addSiteFeedback($data);
            return $this->redirectToRoute('app_feedback');
        }

        $siteFeedbacks = $siteFeedbackService->getAllSiteFeedback();

        return $this->render('siteFeedback/index.html.twig', [
            'siteFeedbacks' => $siteFeedbacks,
            'form' => $form->createView(),
            'averageScore' => $averageScore
        ]);
    }
}
