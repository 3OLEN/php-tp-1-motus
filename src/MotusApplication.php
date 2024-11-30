<?php

declare(strict_types=1);

namespace TpMotus;

use TpMotus\Dto\Motus\MotusConfigurationDto;
use TpMotus\Exception\Motus\StopMotusException;
use TpMotus\Services\Motus\AttemptService;
use TpMotus\Util\Command\Output\ColoredOutputCommandUtil;
use TpMotus\Util\Command\Output\MotusOutputCommandUtil;
use TpMotus\Util\Command\Output\OutputCommandUtil;
use TpMotus\Util\String\WordStringUtil;

class MotusApplication
{
    /**
     * 🎶 Run boy run! This world is not made for you 🎶
     */
    public static function run(MotusConfigurationDto $configuration): void
    {
        OutputCommandUtil::newLine();
        // Introduction du jeu
        static::introduceGame($configuration);

        // Mise en place des tours de jeu
        OutputCommandUtil::newLine();
        static::playGame($configuration);

        OutputCommandUtil::newLine();
    }

    private static function introduceGame(MotusConfigurationDto $configuration): void
    {
        OutputCommandUtil::title('Bienvenue dans le jeu du motus !');
        OutputCommandUtil::writeLn("Vous avez {$configuration->maxAttempts} tentatives pour deviner le mot.");

        MotusOutputCommandUtil::displayHiddenWordToGuess(motusConfiguration: $configuration);

        OutputCommandUtil::writeLn('Règles du jeu :');
        OutputCommandUtil::listing(
            'À chaque tentative, vous devez proposez un word.',
            'Le mot doit commencer par la même lettre : « '
                . WordStringUtil::getFirstLetter($configuration->wordToGuess)
                . ' ».',
            'Le mot doit avoir la même taille : ' . mb_strlen($configuration->wordToGuess) . ' lettres.',
            'Le mot ne doit pas comporter d\'espaces ou de caractères spéciaux. Les accents sont autorisés.',
            'À chaque tentative, vous obtiendrez des indices :',
            '- En ' . ColoredOutputCommandUtil::outputAsGreen('vert') . ' : la lettre est bien placée.',
            '- En ' . ColoredOutputCommandUtil::outputAsOrange('orange') . ' : la lettre est présente mais mal placée.',
            '- Un ' . ColoredOutputCommandUtil::outputAsRed('« * »') . ' : la lettre n\'est pas présente.',
        );

        OutputCommandUtil::writeLn('Bonne chance !');
    }

    private static function playGame(MotusConfigurationDto $configuration): void
    {
        OutputCommandUtil::writeLn('Début du jeu...');
        OutputCommandUtil::newLine();

        $currentAttempt = 0;
        $victory = false;
        while ($currentAttempt <= $configuration->maxAttempts && $victory === false) {
            ++$currentAttempt;
            OutputCommandUtil::subtitle("Tentative n°{$currentAttempt}");
            try {
                $userAttempt = AttemptService::askForWordAttempt(motusConfiguration: $configuration);
            } catch (StopMotusException) {
                OutputCommandUtil::newLine();
                OutputCommandUtil::writeLn(
                    ColoredOutputCommandUtil::outputAsOrange('Demande d\'arrêt du jeu acceptée.')
                );
                OutputCommandUtil::newLine();
                OutputCommandUtil::writeLn('À bientôt !');

                return;
            }
            $victory = AttemptService::validateAttempt(
                motusConfiguration: $configuration,
                wordAttempted: $userAttempt
            );

            MotusOutputCommandUtil::displayAttemptFeedback(
                motusConfiguration: $configuration,
                wordAttempted: $userAttempt
            );
        }

        OutputCommandUtil::writeLn(
            $victory
                ? "Bravo, il vous a fallu {$currentAttempt} tentative·s pour trouver le mot."
                : "Dommage, le mot à trouver était « {$configuration->wordToGuess} »..."
        );
    }
}
