<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\Contracts;

interface BioDtoInterface
{
    /**
     * Get random bio text  
     *
     * @param int $slice 0 to get all text
     * @return string[] 
     */
    public function text(int $slice = 0): array;
}
