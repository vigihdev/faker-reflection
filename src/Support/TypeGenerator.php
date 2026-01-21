<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\Support;

use Faker\Factory;
use Faker\Generator;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionUnionType;
use Vigihdev\FakerReflection\Contracts\FactoryGeneratorInterface;
use Vigihdev\FakerReflection\Provider\{StringProvider, ArrayProvider, BooleanProvider, IntegerProvider};

final class TypeGenerator implements FactoryGeneratorInterface
{
    private Generator $faker;

    private mixed $value = null;


    public function __construct(
        private readonly string $name,
        private readonly ReflectionIntersectionType|ReflectionNamedType|ReflectionUnionType|null $type
    ) {

        $this->faker = Factory::create('id_ID');

        if ($type instanceof ReflectionIntersectionType) {
        }

        if ($type instanceof ReflectionUnionType) {
        }

        if ($type instanceof ReflectionNamedType) {
            $typeName = $type->getName();
            if (!$type->isBuiltin()) {
                if (interface_exists($typeName) || class_exists($typeName)) {
                    $reflection = new ReflectionClass($typeName);
                    $generator = new FactoryGenerator($reflection);
                    $this->value = $generator->generateValue();
                }
                return;
            }

            $method = 'generate' . ucfirst($typeName);
            if (method_exists($this, $method) && is_callable(array($this, $method))) {
                $this->$method();
            }
        }
    }

    public function generateValue(): string|array|int|float|bool|null
    {
        return $this->value;
    }

    private function generateString(): void
    {
        $provider = new StringProvider(
            value: $this->name,
            faker: $this->faker
        );
        $this->value = $provider->generate();
    }

    private function generateArray(): void
    {
        $provider = new ArrayProvider(
            value: $this->name,
            faker: $this->faker
        );
        $this->value = $provider->generate();
    }

    private function generateBool(): void
    {
        $provider = new BooleanProvider(
            value: $this->name,
            faker: $this->faker
        );
        $this->value = $provider->generate();
    }

    private function generateInt(): void
    {
        $provider = new IntegerProvider(
            value: $this->name,
            faker: $this->faker
        );
        $this->value = $provider->generate();
    }
}
