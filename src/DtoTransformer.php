<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection;

use Serializer\Factory\JsonTransformerFactory;
use Vigihdev\FakerReflection\Enums\ProviderResource;
use Vigihdev\FakerReflection\Exceptions\FakerReflectionException;

final class DtoTransformer
{

    public static function fromProviderResource(ProviderResource $resource): object|array
    {

        try {
            return self::fromJsonFile($resource->getPath(), $resource->getDtoClass());
        } catch (\Throwable $e) {
            throw new FakerReflectionException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public static function fromJsonFile(string $filepath, string $dtoClass): object|array
    {
        try {
            $transformer = JsonTransformerFactory::create($dtoClass);
            return $transformer->transformWithFile($filepath);
        } catch (\Throwable $e) {
            throw new FakerReflectionException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public static function fromJsonString(string $json, string $dtoClass): object|array
    {
        try {
            $transformer = JsonTransformerFactory::create($dtoClass);
            $json = trim($json);
            if (substr($json, 0, 1) === '[') {
                return $transformer->transformArrayJson($json);
            }
            return $transformer->transformJson($json);
        } catch (\Throwable $e) {
            throw FakerReflectionException::handleThrowable($e);
        }
    }
}
