<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\Contracts;

interface PriceDtoInterface
{
    public function oneMillionMax(int $slice = 0): array;
}
