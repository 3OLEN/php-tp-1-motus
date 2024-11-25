<?php

declare(strict_types=1);

namespace TpMotus;

use TpMotus\Dto\Motus\MotusConfigurationDto;

class MotusApplication
{
    /**
     * 🎶 Run boy run! This world is not made for you 🎶
     */
    public static function run(MotusConfigurationDto $configuration): void
    {
        echo "Bienvenue dans le jeu du motus !\n";
        echo "Vous avez {$configuration->maxAttempts} tentatives pour deviner le mot.\n";
        echo "\t"
            . mb_substr(string: $configuration->wordToGuess, start: 0, length: 1)
            . ' '
            . implode(
                separator: ' ',
                array: array_fill(start_index: 0, count: mb_strlen($configuration->wordToGuess) - 1, value: '-')
            )
            . "\n";
        echo "Bonne chance !";
    }
}
