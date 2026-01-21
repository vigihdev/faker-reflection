<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\Provider;

use Faker\Generator;

final class ArrayProvider extends AbstractProvider
{

    public function __construct(
        private readonly string $value,
        protected ?Generator $faker = null
    ) {
        parent::__construct($faker);
    }

    public function generate(): array
    {
        $value = strtolower($this->value);

        return match (true) {
            str_contains($value, 'tags') => $this->faker->words(3),
            str_contains($value, 'categories') => $this->faker->words(2),
            str_contains($value, 'images') => array_map(
                fn() => $this->faker->imageUrl(),
                range(1, $this->faker->numberBetween(1, 3))
            ),
            str_contains($value, 'options') => [
                'data-username' => $this->faker->userName(),
                'data-email' => $this->faker->email()
            ],
            str_contains($value, 'items') => array_fill(0, $this->faker->numberBetween(1, 5), [
                'id' => $this->faker->numberBetween(1, 100),
                'name' => $this->faker->word(),
            ]),
            default => []
        };
    }
}
