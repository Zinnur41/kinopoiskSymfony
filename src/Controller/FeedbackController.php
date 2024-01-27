<?php

namespace App\Controller;

use App\Form\SiteFeedbackFormType;
use App\Service\FeedbackService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{
    #[Route('/siteFeedback', name: 'app_feedback')]
    public function index(FeedbackService $feedbackService, Request $request): Response
    {
        $form = $this->createForm(SiteFeedbackFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $feedbackService->addSiteFeedback($data);
            return $this->redirectToRoute('app_feedback');
        }

        $feedbacks = $feedbackService->getAllSiteFeedback();

        return $this->render('feedback/index.html.twig', [
            'feedbacks' => $feedbacks,
            'form' => $form->createView()
        ]);
    }
}
