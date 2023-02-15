<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\AccessToken\AccessTokenExtractorInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Service\TokenService;

class CustomTokenExtractor implements AccessTokenExtractorInterface
{

    public function extractAccessToken(Request $request): ?string
    {
        if (false === strpos($request->getRequestUri(), '/v1')) {
            return null;
        }
        
        $token = $request->headers->get('Authorization');
        if (null === $token) {
            throw new AccessDeniedHttpException('No token provided');
        }

        if (0 !== strpos($token, 'Bearer')) {
            throw new AccessDeniedHttpException('Incorrect token format');
        }

        $token = substr($token, 7);

        $tokenService = new TokenService();

        if ($tokenService->isValid($token)) {
            return $token;
        }

        throw new AccessDeniedHttpException('Invalid token');
    }

}