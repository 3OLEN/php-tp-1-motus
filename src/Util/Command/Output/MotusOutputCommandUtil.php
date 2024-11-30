<?php

declare(strict_types=1);

namespace TpMotus\Util\Command\Output;

use TpMotus\Dto\Motus\MotusConfigurationDto;
use TpMotus\Util\String\DisplayStringUtil;

class MotusOutputCommandUtil
{
    public static function displayHiddenWordToGuess(MotusConfigurationDto $motusConfiguration): void
    {
        OutputCommandUtil::newLine();
        OutputCommandUtil::tab();
        OutputCommandUtil::writeLn(
            message: DisplayStringUtil::replaceStringCharacters(
                string: $motusConfiguration->wordToGuess,
                replacement: '-',
                separator: ' ',
                startingIndex: 1
            )
        );
        OutputCommandUtil::newLine();
    }
}
