<?php

declare(strict_types=1);

namespace TpMotus\Util\String;

class WordStringUtil
{
    /**
     * Rejette les caractères non alphabétiques et convertit le mot en majuscules.
     */
    public static function sanitizeWord(string $word): string
    {
        $sanitizedWord = mb_strtoupper(trim($word));
        if (preg_match('/[^\pL]/u', $sanitizedWord) > 0) {
            throw new \ValueError('Le mot ne doit contenir que des lettres alphabétiques');
        }

        return $sanitizedWord;
    }
}
