<?php

declare(strict_types=1);

namespace TpMotus\Tests\Unit\Dto\Motus\MotusConfigurationDto;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use TpMotus\Dto\Motus\MotusConfigurationDto;

/** @internal */
#[CoversClass(MotusConfigurationDto::class)]
final class ConstructTest extends TestCase
{
    public function testValidConstructUsage(): void
    {
        $configuration = new MotusConfigurationDto(maxAttempts: 2, wordToGuess: 'test');
        static::assertSame(expected: 2, actual: $configuration->maxAttempts);
        static::assertSame(expected: 'TEST', actual: $configuration->wordToGuess);
    }

    #[DataProvider('provideWordToGuessToSanitizeValues')]
    public function testSanitizedWords(string $wordToGuessToSanitize, string $expectedWordToGuess): void
    {
        $configuration = new MotusConfigurationDto(maxAttempts: 2, wordToGuess: $wordToGuessToSanitize);
        static::assertSame(expected: $expectedWordToGuess, actual: $configuration->wordToGuess);
    }

    #[DataProvider('provideInvalidMaxAttemptsValues')]
    public function testInvalidMaxAttempts(int $maxAttempts): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('Le nombre de tentatives doit être supérieur à 0');

        new MotusConfigurationDto(maxAttempts: $maxAttempts, wordToGuess: 'test');
    }

    #[DataProvider('provideInvalidWordToGuessValues')]
    public function testInvalidWordToGuess(string $wordToGuess): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('Le mot à deviner doit contenir au moins 3 lettres');

        new MotusConfigurationDto(maxAttempts: 2, wordToGuess: $wordToGuess);
    }

    #[DataProvider('provideInvalidWordToGuessToSanitizeValues')]
    public function testInvalidWordToGuessFromSanitize(string $wordToGuessToSanitize): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('Le mot ne doit contenir que des lettres alphabétiques');

        new MotusConfigurationDto(maxAttempts: 2, wordToGuess: $wordToGuessToSanitize);
    }

    public static function provideWordToGuessToSanitizeValues(): iterable
    {
        yield 'it_transforms_to_uppercase' => ['wordToGuessToSanitize' => 'LivRe', 'expectedWordToGuess' => 'LIVRE'];
        yield 'it_trims_spaces' => ['wordToGuessToSanitize' => '  carte  ', 'expectedWordToGuess' => 'CARTE'];
        yield 'it_keeps_accents' => ['wordToGuessToSanitize' => 'événement', 'expectedWordToGuess' => 'ÉVÉNEMENT'];
    }

    public static function provideInvalidMaxAttemptsValues(): iterable
    {
        yield 'it_rejects_zero_as_max_attempts' => ['maxAttempts' => 0];
        yield 'it_rejects_negative_as_max_attempts' => ['maxAttempts' => -10];
    }

    public static function provideInvalidWordToGuessValues(): iterable
    {
        yield 'it_rejects_empty_string_as_word_to_guess' => ['wordToGuess' => ''];
        yield 'it_rejects_string_with_less_than_3_characters_as_word_to_guess' => ['wordToGuess' => 'ou'];
        yield 'it_rejects_string_with_accents_with_less_than_3_characters_as_word_to_guess' => ['wordToGuess' => 'où'];
    }

    public static function provideInvalidWordToGuessToSanitizeValues(): iterable
    {
        yield 'it_rejects_word_to_guess_with_numbers' => ['wordToGuessToSanitize' => 'test1'];
        yield 'it_rejects_word_to_guess_with_space' => ['wordToGuessToSanitize' => 'te st'];
        yield 'it_rejects_word_to_guess_with_special_characters' => ['wordToGuessToSanitize' => 'test!'];
    }
}
