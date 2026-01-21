<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\DTOs;

use Vigihdev\FakerReflection\Contracts\SubdistrictDtoInterface;

final class SubdistrictDto implements SubdistrictDtoInterface
{
    public function __construct(
        private readonly array $items = []
    ) {}
}
