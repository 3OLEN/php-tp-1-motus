<?php

declare(strict_types=1);

namespace TpMotus\Util\Command\Output;

class ColoredOutputCommandUtil
{
    public static function outputAsCyan(string $message): string
    {
        return "\033[1;36m{$message}\033[0m";
    }

    public static function outputAsGreen(string $message): string
    {
        return "\033[1;32m{$message}\033[0m";
    }

    public static function outputAsOrange(string $message): string
    {
        return "\033[1;33m{$message}\033[0m";
    }

    public static function outputAsRed(string $message): string
    {
        return "\033[1;31m{$message}\033[0m";
    }

    public static function outputAsViolet(string $message): string
    {
        return "\033[1;35m{$message}\033[0m";
    }
}
