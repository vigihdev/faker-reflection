<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\Contracts;


interface FactoryGeneratorInterface
{
    public function generateValue(): array|string|int|float|bool|null;
}
