<?php

declare(strict_types=1);

use TpMotus\Dto\Motus\MotusConfigurationDto;
use TpMotus\MotusApplication;
use TpMotus\Services\Motus\WordPickerService;

require_once __DIR__ . '/vendor/autoload.php';

// Mise en place de l'application
MotusApplication::run(
    configuration: new MotusConfigurationDto(
        maxAttempts: 4,
        wordToGuess: WordPickerService::pickRandom(),
    )
);
