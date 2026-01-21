<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\DTOs;

use Vigihdev\FakerReflection\Contracts\VehicleDtoInterface;

final class VehicleDto implements VehicleDtoInterface
{

    public function __construct(
        private readonly array $mobils = [],
        private readonly array $paketSewas = []
    ) {}

    public function mobils(): array
    {
        return $this->mobils;
    }

    public function paketSewas(): array
    {
        return $this->paketSewas;
    }

    public function randomMobil(): string
    {
        return $this->mobils[array_rand($this->mobils)];
    }

    public function randomPaketSewa(): string
    {
        return $this->paketSewas[array_rand($this->paketSewas)];
    }
}
