<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection;

use ReflectionClass;
use Vigihdev\FakerReflection\Contracts\FakerReflectionInterface;
use Vigihdev\FakerReflection\Support\TypeGenerator;
use Vigihdev\Support\Collection;

final class FakerReflection implements FakerReflectionInterface
{
    private array $resultGenerators = [];

    public function __construct(
        private readonly ReflectionClass $reflection,
        private readonly int $count,
    ) {}

    public function generate(): Collection
    {
        $reflection = $this->reflection;

        if (
            $reflection->isInterface() || $reflection->isAbstract() || $reflection->isTrait()
        ) {
            return new Collection([]);
        }

        $properties = $reflection->getProperties();

        foreach ($properties as $index => $property) {
            $name = $property->getName();
            $type = $property->getType();

            if ($type === null) {
                continue;
            }

            for ($i = 0; $i < $this->count; $i++) {
                $generator = new TypeGenerator($name, $type);
                $value = $generator->generateValue();
                $this->resultGenerators[$i][$name] = $value;
            }
        }

        return new Collection($this->resultGenerators);
    }
}
