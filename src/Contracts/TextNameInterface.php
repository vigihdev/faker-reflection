<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\Contracts;

interface TextNameInterface
{
    public function name(): array;

    public function text(): array;

    public function randomName(): string;

    public function randomText(): string;
}
