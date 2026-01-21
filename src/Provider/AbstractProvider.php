<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\Provider;

use Faker\Factory;
use Faker\Generator;
use Faker\Provider\Base as BaseProvider;

abstract class AbstractProvider extends BaseProvider
{

    abstract public function generate(): int|string|array|bool;

    public function __construct(
        protected ?Generator $faker = null
    ) {
        if ($this->faker === null) {
            $this->faker = Factory::create('id_ID');
        }
    }
}
