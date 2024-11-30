<?php

declare(strict_types=1);

namespace TpMotus\Util\String;

class DisplayStringUtil
{
    public static function getRepeatedString(string $string, int $count): string
    {
        if ($count === 0) {
            throw new \InvalidArgumentException("La chaîne doit être répétée au moins une fois (fourni : {$count}).");
        }
        if (mb_strlen($string) === 0) {
            throw new \InvalidArgumentException("La chaîne ne peut pas être vide.");
        }

        return implode(
            separator: '',
            array: array_fill(start_index: 0, count: $count, value: $string)
        );
    }

    public static function replaceStringCharacters(
        string $string,
        string $replacement,
        string $separator = '',
        int $startingIndex = 0
    ): string {
        if (mb_strlen($string) === 0) {
            throw new \InvalidArgumentException("La chaîne ne peut pas être vide.");
        }
        if ($startingIndex < 0) {
            throw new \InvalidArgumentException("L'index de départ doit être positif (fourni : {$startingIndex}).");
        }

        return (
                $startingIndex > 0
                    ? implode(
                        separator: $separator,
                        array: mb_str_split(
                            string: mb_substr(string: $string, start: 0, length: $startingIndex)
                        )
                    )
                    : ''
            )
            . ($startingIndex > 0 ? $separator : '')
            . implode(
                separator: $separator,
                array: array_fill(
                    start_index: $startingIndex,
                    count: mb_strlen($string) - $startingIndex,
                    value: $replacement
                )
            );
    }
}
