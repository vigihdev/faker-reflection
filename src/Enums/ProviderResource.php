<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\Enums;

use Vigihdev\FakerReflection\DTOs\PriceDto;

enum ProviderResource: string
{
    case PRICE = 'resources/provider/price';

    public function getDtoClass(): string
    {
        return match ($this) {
            self::PRICE => PriceDto::class,
        };
    }

    public function getPath(): string
    {
        return "{$this->value}.json";
    }
}
