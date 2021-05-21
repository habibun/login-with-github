<?php

namespace App\Security;

use App\Github\GithubUserProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class GithubAuthenticator extends AbstractGuardAuthenticator
{
     private $provider;
    /**
     * GithubAuthenticator constructor.
     */
    public function __construct(GithubUserProvider $provider)
    {
        $this->provider = $provider;
    }

    public function supports(Request $request)
    {
        return $request->query->get('code'); //I get the code from Github authorization response
    }

    public function getCredentials(Request $request)
    {
        return [
            'code' => $request->query->get('code')
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        //Logic get user from github

        return $this->provider->loadUserFromGithub($credentials['code']);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // todo
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        // todo
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse("Not Authorized");
    }

    public function supportsRememberMe()
    {
        // todo
    }
}
