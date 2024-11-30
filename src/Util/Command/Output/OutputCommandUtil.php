<?php

declare(strict_types=1);

namespace TpMotus\Util\Command\Output;

use TpMotus\Util\String\DisplayStringUtil;

class OutputCommandUtil
{
    public static function title(string $title): void
    {
        static::writeLn(
            message: ColoredOutputCommandUtil::outputAsViolet(
                "{$title}\n"
                    . DisplayStringUtil::getRepeatedString(string: '=', count: mb_strlen($title))
            )
        );
        static::newLine();
    }

    public static function subtitle(string $subtitle): void
    {
        static::writeLn(
            message: ColoredOutputCommandUtil::outputAsCyan(
                "{$subtitle}\n"
                    . DisplayStringUtil::getRepeatedString(string: '-', count: mb_strlen($subtitle))
            )
        );
        static::newLine();
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

    public static function listing(string ...$items): void
    {
        static::newLine();
        foreach ($items as $item) {
            static::tab();
            if (str_starts_with(haystack: $item, needle: '- ')) {
                static::tab();
                static::writeLn($item);
            } else {
                static::writeLn("* {$item}");
            }
        }
        static::newLine();
    }

    public static function newLine(): void
    {
        echo "\n";
    }

    public static function tab(): void
    {
        echo "\t";
    }
}
