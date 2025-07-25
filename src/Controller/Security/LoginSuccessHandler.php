<?php

namespace App\Controller\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): RedirectResponse
    {
        /** @var \App\Entity\User|null $user */
        $user = $token->getUser();

        if (in_array('ROLE_EDITOR', $user->getRoles())) {
            return new RedirectResponse($this->router->generate('admin_index'));
        }

        return new RedirectResponse($this->router->generate('app_dashboard_user', [
            'id' => $user->getId()
        ]));
    }
}
