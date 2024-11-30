<?php

declare(strict_types=1);

namespace TpMotus\Util\Command\Output;

use TpMotus\Dto\Motus\MotusAttemptDto;
use TpMotus\Dto\Motus\MotusConfigurationDto;
use TpMotus\Util\String\DisplayStringUtil;
use TpMotus\Util\String\WordStringUtil;

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

    public static function displayAttemptFeedback(
        MotusConfigurationDto $motusConfiguration,
        MotusAttemptDto $wordAttempted
    ): void {
        OutputCommandUtil::newLine();
        OutputCommandUtil::tab();
        // Vérification lettre par lettre
        foreach (mb_str_split(string: $wordAttempted->word) as $attemptIndex => $attemptLetter) {
            if ($attemptIndex === 0) {
                // La première lettre est toujours la même
                OutputCommandUtil::write(WordStringUtil::getFirstLetter($motusConfiguration->wordToGuess));

                continue;
            }

            OutputCommandUtil::write(' ');
            $match = false;
            foreach (mb_str_split(string: $motusConfiguration->wordToGuess) as $wordIndex => $wordLetter) {
                if ($attemptLetter === $wordLetter) {
                    $match = true;
                    if ($attemptIndex === $wordIndex) {
                        OutputCommandUtil::write(ColoredOutputCommandUtil::outputAsGreen($attemptLetter));
                    } else {
                        OutputCommandUtil::write(ColoredOutputCommandUtil::outputAsOrange($attemptLetter));
                    }

                    break;
                }
            }
            if ($match) {
                continue;
            }

            OutputCommandUtil::write(ColoredOutputCommandUtil::outputAsRed('*'));
        }

        OutputCommandUtil::newLine();
        OutputCommandUtil::newLine();
    }
}
