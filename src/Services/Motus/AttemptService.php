<?php

declare(strict_types=1);

namespace TpMotus\Services\Motus;

use TpMotus\Dto\Motus\MotusAttemptDto;
use TpMotus\Dto\Motus\MotusConfigurationDto;
use TpMotus\Util\Command\Input\UserInputUtil;
use TpMotus\Util\Command\Output\ColoredOutputCommandUtil;
use TpMotus\Util\Command\Output\OutputCommandUtil;
use TpMotus\Util\String\WordStringUtil;

class AttemptService
{
    public static function validateAttempt(
        MotusConfigurationDto $motusConfiguration,
        MotusAttemptDto $wordAttempted
    ): bool {
        if (mb_strlen($wordAttempted->word) !== mb_strlen($motusConfiguration->wordToGuess)) {
            return false;
        }
        if ($motusConfiguration->wordToGuess === $wordAttempted->word) {
            return true;
        }

        // Validation lettre par lettre
        $splitWordAttempted = mb_str_split($wordAttempted->word);
        foreach (mb_str_split($motusConfiguration->wordToGuess) as $cursor => $letterToGuess) {
            if (
                $letterToGuess === $splitWordAttempted[$cursor]
                || iconv('UTF-8', 'ASCII//TRANSLIT', $letterToGuess) === $splitWordAttempted[$cursor]
            ) {
                // 1. Exactement la même lettre
                // 2. La lettre est un accent et la lettre de l'essai est la même lettre, mais non accentuée
                continue;
            }

            return false;
        }

        return true;
    }

    public static function askForWordAttempt(MotusConfigurationDto $motusConfiguration): MotusAttemptDto
    {
        while (true) {
            $wordAttempted = UserInputUtil::ask('Proposez un mot : ');

            $errorMessage = match (true) {
                mb_strlen($wordAttempted) === 0 => 'Le mot ne peut pas être vide.',
                mb_strlen($wordAttempted) !== mb_strlen($motusConfiguration->wordToGuess) =>
                    'Le mot doit avoir la même taille ('
                    . mb_strlen($motusConfiguration->wordToGuess)
                    . ' lettres).',
                WordStringUtil::isSanitizeValid($wordAttempted) === false =>
                    'Vérifiez votre saisie : seulement des lettres (accents autorisés).',
                WordStringUtil::getFirstLetter($wordAttempted)
                    !== WordStringUtil::getFirstLetter($motusConfiguration->wordToGuess) =>
                        'Le mot doit commencer par la lettre « '
                        . WordStringUtil::getFirstLetter($motusConfiguration->wordToGuess)
                        . ' ».',
                default => null,
            };
            if ($errorMessage !== null) {
                OutputCommandUtil::writeLn(ColoredOutputCommandUtil::outputAsRed('Saisie invalide !'));
                OutputCommandUtil::tab();
                OutputCommandUtil::writeLn(ColoredOutputCommandUtil::outputAsRed(">> {$errorMessage}"));

                continue;
            }

            return new MotusAttemptDto(word: $wordAttempted);
        }
    }
}
