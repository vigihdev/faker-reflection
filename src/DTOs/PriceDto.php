<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\DTOs;

use Vigihdev\FakerReflection\Contracts\PriceDtoInterface;

final class PriceDto implements PriceDtoInterface
{
    public function __construct(
        private readonly array $oneMillionMax = [],
    ) {}

    public function oneMillionMax(int $slice = 0): array
    {
        return array_slice($this->oneMillionMax, $slice);
    }
}
