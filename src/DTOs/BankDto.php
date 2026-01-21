<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\DTOs;

use Vigihdev\FakerReflection\Contracts\BankDtoInterface;

final class BankDto implements BankDtoInterface
{
    public function __construct(
        private readonly array $names = [],
        private readonly array $texts = []
    ) {}

    public function name(): array
    {
        return $this->names;
    }

    public function text(): array
    {
        return $this->texts;
    }

    public function randomName(): string
    {
        return $this->names[array_rand($this->names)];
    }

    public function randomText(): string
    {
        return $this->texts[array_rand($this->texts)];
    }
}
