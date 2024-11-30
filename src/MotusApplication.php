<?php

declare(strict_types=1);

namespace TpMotus;

use TpMotus\Dto\Motus\MotusConfigurationDto;
use TpMotus\Util\Command\Output\OutputCommandUtil;
use TpMotus\Util\String\DisplayStringUtil;

class MotusApplication
{
    /**
     * 🎶 Run boy run! This world is not made for you 🎶
     */
    public static function run(MotusConfigurationDto $configuration): void
    {
        OutputCommandUtil::newLine();
        OutputCommandUtil::title('Bienvenue dans le jeu du motus !');
        OutputCommandUtil::writeLn("Vous avez {$configuration->maxAttempts} tentatives pour deviner le mot.");
        OutputCommandUtil::newLine();
        OutputCommandUtil::writeLn(
            "\t"
            . DisplayStringUtil::replaceStringCharacters(
                string: $configuration->wordToGuess,
                replacement: '-',
                separator: ' ',
                startingIndex: 1
            )
        );
        OutputCommandUtil::newLine();
        OutputCommandUtil::write('Bonne chance !');
        OutputCommandUtil::newLine();
    }
}
