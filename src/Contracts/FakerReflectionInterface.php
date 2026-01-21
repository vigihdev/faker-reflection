<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\Contracts;

use Vigihdev\Support\Collection;

interface FakerReflectionInterface
{
    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function generate(): Collection;
}
