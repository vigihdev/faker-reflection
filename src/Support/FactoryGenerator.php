<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\Support;

use ReflectionClass;
use Vigihdev\FakerReflection\Contracts\FactoryGeneratorInterface;

final class FactoryGenerator implements FactoryGeneratorInterface
{
    private array $typeGenerators = [];

    public function __construct(
        private readonly ReflectionClass $reflection,
    ) {

        $this->initialize();
    }

    private function initialize(): void
    {
        $reflection = $this->reflection;
        switch (true) {
            case $reflection->isInterface():
                $this->getMethodReturnType();
                break;
            default:
                $this->getPropertiesType();
                break;
        }
    }


    public function generateValue(): array
    {
        return $this->typeGenerators;
    }

    private function getPropertiesType(): void
    {
        $properties = $this->reflection->getProperties();
        foreach ($properties as $property) {
            $name = $property->getName();
            $type = $property->getType();

            if ($type === null) {
                continue;
            }

            $generator = new TypeGenerator($name, $type);
            $this->typeGenerators[$name] = $generator->generateValue();
        }
    }

    private function getMethodReturnType(): void
    {
        foreach ($this->reflection->getMethods() as $method) {
            $name = $method->getName();
            $type = $method->getReturnType();
            $generator = new TypeGenerator($name, $type);

            $keyName = preg_replace('/^get/', '', $name);
            $keyName = lcfirst($keyName);
            $this->typeGenerators[$keyName] = $generator->generateValue();
        }
    }
}
