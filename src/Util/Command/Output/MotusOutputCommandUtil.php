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
        // Vérification lettre par lettre
        $validatedLetters = [];
        $validatedLetterCounts = [];
        $wronglyPlacedLetters = [];
        foreach (mb_str_split(string: $wordAttempted->word) as $attemptIndex => $attemptLetter) {
            if ($attemptIndex === 0) {
                // La première lettre est toujours la même
                $validatedLetters[$attemptIndex] = $attemptLetter;
                $validatedLetterCounts[$attemptLetter] = 1;

                continue;
            }

            OutputCommandUtil::write(' ');
            foreach (mb_str_split(string: $motusConfiguration->wordToGuess) as $wordIndex => $wordLetter) {
                if ($wordIndex === 0) {
                    // Ignorer la première lettre, car c'est la même
                    continue;
                }

                if ($attemptLetter === $wordLetter) {
                    if ($attemptIndex === $wordIndex) {
                        $validatedLetters[$attemptIndex] = $attemptLetter;
                        $validatedLetterCounts[$attemptLetter] = ($validatedLetterCounts[$attemptLetter] ?? 0) + 1;
                    } elseif (
                        ($validatedLetterCounts[$attemptLetter] ?? 0)
                            < $motusConfiguration->letterCounts[$attemptLetter]
                    ) {
                        $wronglyPlacedLetters[$attemptIndex] = $attemptLetter;
                    }

                    break;
                }
            }
        }

        // Affichage
        OutputCommandUtil::newLine();
        OutputCommandUtil::tab();
        $treatedWronglyPlacedLetters = [];
        foreach (mb_str_split(string: $wordAttempted->word) as $letterIndex => $letter) {
            if ($letterIndex > 0) {
                OutputCommandUtil::write(' ');
            }

            if (isset($validatedLetters[$letterIndex])) {
                OutputCommandUtil::write(ColoredOutputCommandUtil::outputAsGreen($letter));
            } elseif (
                isset($wronglyPlacedLetters[$letterIndex])
                && (
                    ($validatedLetterCounts[$letter] ?? 0)
                    + ($treatedWronglyPlacedLetters[$letter] ?? 0)
                ) < $motusConfiguration->letterCounts[$letter]
            ) {
                OutputCommandUtil::write(ColoredOutputCommandUtil::outputAsOrange($letter));
                $treatedWronglyPlacedLetters[$letter] = ($treatedWronglyPlacedLetters[$letter] ?? 0) + 1;
            } else {
                OutputCommandUtil::write(ColoredOutputCommandUtil::outputAsRed('*'));
            }
        }
        OutputCommandUtil::newLine();
        OutputCommandUtil::newLine();
    }
}
