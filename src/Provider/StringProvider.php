<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\Provider;

use Faker\Generator;

final class StringProvider extends AbstractProvider
{

    public function __construct(
        private readonly string $value,
        protected ?Generator $faker = null
    ) {
        parent::__construct($faker);
    }

    public function generate(): string
    {
        $value = lcfirst($this->value);

        // Priority-based pattern matching
        $patterns = [
            // Email patterns
            '/email|_email/' => fn() => $this->faker->email(),

            // Name patterns
            '/name/' => fn() => $this->faker->name(),
            '/fullname/' => fn() => $this->faker->name(),
            '/username/' => fn() => $this->faker->userName(),

            // Title patterns
            '/title|label|_title/' => fn() => $this->faker->sentence(3),

            // Content patterns
            '/content/' => fn() => $this->faker->paragraphs(2, true),
            '/description/' => fn() => $this->faker->paragraph(),
            '/body/' => fn() => $this->faker->text(300),

            // Address patterns
            '/address/' => fn() => $this->faker->address(),
            '/street/' => fn() => $this->faker->streetAddress(),
            '/city/' => fn() => $this->faker->city(),
            '/country/' => fn() => $this->faker->country(),

            // Phone patterns
            '/phone|(contact)Value$/' => fn() => $this->faker->phoneNumber(),
            '/tel/' => fn() => $this->faker->phoneNumber(),
            '/mobile/' => fn() => $this->faker->phoneNumber(),
            '/(contact)Type$/' => fn() => $this->faker->randomElement(['Phone', 'Mobile', 'House', 'Whatsapp']),

            // URL patterns
            '/url|(action|button|home)Url$/' => fn() => $this->faker->url(),
            '/website/' => fn() => $this->faker->url(),
            '/avatar|(icon)Url$/' => fn() => $this->faker->imageUrl(100, 100),
            '/image/' => fn() => $this->faker->imageUrl(),

            // Date patterns
            '/date/' => fn() => $this->faker->date('Y-m-d'),
            '/_at$/' => fn() => $this->faker->dateTime()->format('Y-m-d H:i:s'),
            '/_on$/' => fn() => $this->faker->date('Y-m-d'),

            // Code patterns
            '/code/' => fn() => strtoupper($this->faker->bothify('??###')),
            '/token/' => fn() => bin2hex(random_bytes(16)),
            '/uuid/' => fn() => $this->faker->uuid(),

            // Status patterns
            '/status/' => fn() => $this->faker->randomElement(['active', 'inactive', 'pending']),
            '/state/' => fn() => $this->faker->randomElement(['draft', 'published', 'archived']),
            '/type/' => fn() => $this->faker->randomElement(['admin', 'user', 'guest']),
            '/role/' => fn() => $this->faker->randomElement(['admin', 'editor', 'viewer']),

            // Password patterns
            '/password/' => fn() => password_hash('password123', PASSWORD_DEFAULT),

            // Color patterns
            '/color/' => fn() => $this->faker->hexColor(),

            // Currency patterns
            '/currency$/' => fn() => $this->faker->currencyCode(),
        ];

        $patterns = array_merge($patterns, PatternBasedStringProvider::build($this->faker));

        foreach ($patterns as $pattern => $generator) {
            if (preg_match($pattern, $value)) {
                return (string) $generator();
            }
        }

        // Fallback untuk string lainnya
        if (str_starts_with($value, 'is_') || str_starts_with($value, 'has_')) {
            return $this->faker->boolean() ? 'true' : 'false';
        }

        return $this->faker->text(50);
    }
}
