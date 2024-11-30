<?php

declare(strict_types=1);

namespace TpMotus\Util\Command\Output;

class ColoredOutputCommandUtil
{
    public static function outputAsViolet(string $message): string
    {
        return "\033[1;35m{$message}\033[0m";
    }
}
