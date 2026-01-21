<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\Contracts;

interface VehicleDtoInterface
{
    public function mobils(): array;

    public function paketSewas(): array;

    public function randomMobil(): string;

    public function randomPaketSewa(): string;
}
