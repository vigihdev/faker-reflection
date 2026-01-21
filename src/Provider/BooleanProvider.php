<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\Provider;

use Faker\Generator;

final class BooleanProvider extends AbstractProvider
{

    public function __construct(
        private readonly string $value,
        protected ?Generator $faker = null
    ) {
        parent::__construct($faker);
    }

    public function generate(): bool
    {
        $value = strtolower($this->value);

        return match (true) {
            str_starts_with($value, 'is_') => $this->faker->boolean(),
            str_starts_with($value, 'has_') => $this->faker->boolean(),
            str_starts_with($value, 'can_') => $this->faker->boolean(),
            str_contains($value, 'active') => $this->faker->boolean(80), // 80% true
            str_contains($value, 'verified') => $this->faker->boolean(70),
            str_contains($value, 'enabled') => $this->faker->boolean(90),
            default => $this->faker->boolean()
        };
    }
}
