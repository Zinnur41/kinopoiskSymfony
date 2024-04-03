<?php

namespace App\Security;

use App\Service\UserService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AdminLoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private $router;
    private $security;
    private $userService;

    public function __construct(RouterInterface $router, Security $security, UserService $userService)
    {
        $this->router = $router;
        $this->security = $security;
        $this->userService = $userService;
    }


    public function onAuthenticationSuccess(Request $request, TokenInterface $token): ?Response
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return new RedirectResponse($this->router->generate('app_admin_getUsers'));
        }
        $this->userService->checkSubscription();
        return new RedirectResponse($this->router->generate('app_index'));
    }
}