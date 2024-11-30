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
        static::assertNoSpecialCharacters($sanitizedWord);

        return $sanitizedWord;
    }

    /**
     * Réalise une vérification avec la méthode {@see sanitizeWord()}.
     */
    public static function getFirstLetter(string $word): string
    {
        $sanitizedWord = static::sanitizeWord($word);
        if (mb_strlen($sanitizedWord) === 0) {
            throw new \ValueError('Le mot ne peut pas être vide');
        }

        return mb_substr(string: $sanitizedWord, start: 0, length: 1);
    }

    private static function assertNoSpecialCharacters(string $givenString): void
    {
        if (preg_match('/[^\pL]/u', $givenString) === 0) {
            return;
        }

        throw new \ValueError('Le mot ne doit contenir que des lettres alphabétiques');
    }
}
