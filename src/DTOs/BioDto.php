<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\DTOs;

use Vigihdev\FakerReflection\Contracts\BioDtoInterface;

final class BioDto implements BioDtoInterface
{
    public function __construct(
        private readonly array $text = [],
    ) {}

    public function text(int $slice = 0): array
    {
        return array_slice($this->text, $slice);
    }
}
