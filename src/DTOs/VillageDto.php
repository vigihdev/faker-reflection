<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\DTOs;

use Vigihdev\FakerReflection\Contracts\VillageDtoInterface;

final class VillageDto implements VillageDtoInterface
{
    public function __construct(
        private readonly array $items = []
    ) {}
}
