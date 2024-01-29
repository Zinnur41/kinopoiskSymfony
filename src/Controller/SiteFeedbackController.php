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
    public function index(SiteFeedbackService $feedbackService, Request $request): Response
    {
        $averageScore = $feedbackService->getAverageScore();

        $form = $this->createForm(SiteFeedbackFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $feedbackService->addSiteFeedback($data);
            return $this->redirectToRoute('app_feedback');
        }

        $feedbacks = $feedbackService->getAllSiteFeedback();

        return $this->render('siteFeedback/index.html.twig', [
            'feedbacks' => $feedbacks,
            'form' => $form->createView(),
            'averageScore' => $averageScore
        ]);
    }
}
