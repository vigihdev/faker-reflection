<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\Exceptions;

interface FakerReflectionExceptionInterface extends \Throwable
{
    public function getContext(): array;

    public function getSolutions(): array;

    public function toArray(): array;

    public function getFormattedMessage(): string;
}
