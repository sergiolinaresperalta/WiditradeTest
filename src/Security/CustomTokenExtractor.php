<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\AccessToken\AccessTokenExtractorInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CustomTokenExtractor implements AccessTokenExtractorInterface
{

    public function extractAccessToken(Request $request): ?string
    {
        $token = $request->headers->get('Authorization');
        if (null === $token) {
            throw new AccessDeniedHttpException('No token provided');
        }

        if (0 !== strpos($token, 'Bearer')) {
            throw new AccessDeniedHttpException('Incorrect token format');
        }

        $token = substr($token, 7);
        if ($this->isValid($token)) {
            return $token;
        }

        throw new AccessDeniedHttpException('Invalid token');
    }

    public function isValid($string) : bool
    {
        $stack = [];
        $open = ['{', '[', '('];
        $close = ['}', ']', ')'];
        
        if (preg_match('/[^{}[\]()]/', $string)) {
            return false;
        }

        for ($i = 0; $i < strlen($string); $i++) {
            if (in_array($string[$i], $open)) {
                $stack[] = $string[$i];
            } else if (in_array($string[$i], $close)) {
                $last = array_pop($stack);
                if ($last != $open[array_search($string[$i], $close)]) {
                    return false;
                }
            }
        }
        return count($stack) == 0;
    }

}