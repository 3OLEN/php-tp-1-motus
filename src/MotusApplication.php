<?php

declare(strict_types=1);

namespace TpMotus;

use TpMotus\Dto\Motus\MotusConfigurationDto;
use TpMotus\Util\Command\Output\MotusOutputCommandUtil;
use TpMotus\Util\Command\Output\OutputCommandUtil;

class MotusApplication
{
    /**
     * 🎶 Run boy run! This world is not made for you 🎶
     */
    public static function run(MotusConfigurationDto $configuration): void
    {
        // Introduction du jeu
        OutputCommandUtil::newLine();
        OutputCommandUtil::title('Bienvenue dans le jeu du motus !');
        OutputCommandUtil::writeLn("Vous avez {$configuration->maxAttempts} tentatives pour deviner le mot.");

        MotusOutputCommandUtil::displayHiddenWordToGuess(motusConfiguration: $configuration);

        OutputCommandUtil::write('Bonne chance !');
        OutputCommandUtil::newLine();
    }
}
