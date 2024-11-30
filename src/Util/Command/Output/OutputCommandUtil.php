<?php

declare(strict_types=1);

namespace TpMotus\Util\Command\Output;

use TpMotus\Util\String\DisplayStringUtil;

class OutputCommandUtil
{
    public static function title(string $title): void
    {
        echo "\033[1;32m{$title}\n"
            . DisplayStringUtil::getRepeatedString(string: '=', count: mb_strlen($title))
            . "\033[0m\n\n";
    }

    public static function write(string $message): void
    {
        echo $message;
    }

    public static function writeLn(string $message): void
    {
        static::write($message);
        static::newLine();
    }

    public static function newLine(): void
    {
        echo "\n";
    }
}
