<?php

declare(strict_types=1);

namespace TpMotus\Dto\Motus;

use TpMotus\Util\String\WordStringUtil;

readonly class MotusConfigurationDto
{
    public int $maxAttempts;

    public string $wordToGuess;

    public function __construct(
        int $maxAttempts,
        string $wordToGuess,
    ) {
        if ($maxAttempts < 1) {
            throw new \ValueError('Le nombre de tentatives doit être supérieur à 0');
        }
        $this->maxAttempts = $maxAttempts;

        $sanitizedWord = WordStringUtil::sanitizeWord($wordToGuess);
        if (mb_strlen($sanitizedWord) < 3) {
            throw new \ValueError('Le mot à deviner doit contenir au moins 3 lettres');
        }
        $this->wordToGuess = $sanitizedWord;
    }
}
