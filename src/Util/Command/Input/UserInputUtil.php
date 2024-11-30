<?php

declare(strict_types=1);

namespace TpMotus\Util\Command\Input;

use TpMotus\Exception\Motus\StopMotusException;

class UserInputUtil
{
    public static function ask(string $question): string
    {
        $input = readline($question);
        if ($input === false) {
            throw new StopMotusException();
        }

        return trim($input);
    }
}
