<?php

declare(strict_types=1);

namespace TpMotus\Dto\Motus;

use TpMotus\Util\String\WordStringUtil;

readonly class MotusAttemptDto
{
    public string $word;

    public function __construct(
        string $word
    ) {
        $this->word = WordStringUtil::sanitizeWord($word);
    }
}
