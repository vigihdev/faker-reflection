<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\Provider;

use Faker\Generator;
use Vigihdev\FakerReflection\Contracts\PriceDtoInterface;
use Vigihdev\FakerReflection\Enums\ProviderResource;
use Vigihdev\FakerReflection\DtoTransformer;

final class IntegerProvider extends AbstractProvider
{

    private ?PriceDtoInterface $dtoProvider = null;

    public function __construct(
        private readonly string $value,
        protected ?Generator $faker = null
    ) {

        parent::__construct($faker);

        if ($this->dtoProvider === null) {
            $this->dtoProvider = DtoTransformer::fromProviderResource(ProviderResource::PRICE);
        }
    }

    public function generate(): int
    {
        $value = strtolower($this->value);

        return match (true) {
            // ID patterns
            str_ends_with($value, 'id') => $this->faker->numberBetween(1, 10000),
            str_contains($value, 'user_id') => $this->faker->numberBetween(1, 100),
            str_contains($value, 'product_id') => $this->faker->numberBetween(1, 1000),

            // Age patterns
            str_contains($value, 'age') => $this->faker->numberBetween(18, 65),

            // Quantity patterns
            str_contains($value, 'quantity') => $this->faker->numberBetween(0, 100),
            str_contains($value, 'harga') => $this->faker->randomElement($this->dtoProvider->oneMillionMax(10)),
            str_contains($value, 'stock') => $this->faker->numberBetween(0, 1000),
            str_contains($value, 'count') => $this->faker->numberBetween(0, 50),

            // Status codes
            str_contains($value, 'status_code') => $this->faker->randomElement([200, 201, 400, 404, 500]),
            str_contains($value, 'code') => $this->faker->randomNumber(4),

            // Year patterns
            str_contains($value, 'year') => $this->faker->numberBetween(2000, 2024),

            // Default
            default => $this->faker->numberBetween(1, 1000)
        };
    }
}
