<?php

namespace App\Service;

class TokenService
{
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