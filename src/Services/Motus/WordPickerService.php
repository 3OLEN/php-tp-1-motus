<?php

declare(strict_types=1);

namespace TpMotus\Services\Motus;

class WordPickerService
{
    private static array $wordList = [
        'abattre',
        'abdomen',
        'aboi',
        'abri',
        'accord',
        'accro',
        'accès',
        'achat',
        'addition',
        'adieu',
        'admettre',
        'adopter',
        'aérer',
        'aéroport',
        'affaire',
        'affiche',
        'affreux',
        'agir',
        'agiter',
        'agonie',
        'agrafe',
        'ahuri',
        'aide',
        'aigle',
        'aiguille',
        'ainsi',
        'ajourner',
        'ajouter',
        'ajuster',
        'allégresse',
        'allié',
        'allumer',
        'alors',
        'amarrage',
        'amener',
        'amoindrir',
        'amuser',
        'ancre',
        'ange',
        'angle',
        'animal',
        'aplat',
        'appel',
        'apôtre',
        'appétit',
        'aquarium',
        'aqueduc',
        'arbre',
        'arme',
        'armée',
        'arôme',
        'artiste',
        'asile',
        'aspect',
        'assaut',
        'assemblée',
        'attente',
        'atténuer',
        'attirer',
        'attraper',
        'auberge',
        'audace',
        'auparavant',
        'aurore',
        'avalanche',
        'aviron',
        'avocat',
        'avouer',
    ];

    public static function pickRandom(): string
    {
        return static::$wordList[array_rand(static::$wordList)];
    }
}
