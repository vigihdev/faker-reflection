<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\DTOs;

use Vigihdev\FakerReflection\Contracts\ProvinceDtoInterface;

final class ProvinceDto implements ProvinceDtoInterface
{
    public function __construct(
        private readonly array $items = []
    ) {}
}
