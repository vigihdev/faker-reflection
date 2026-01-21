<?php

declare(strict_types=1);

namespace Vigihdev\FakerReflection\Enums;

use Vigihdev\FakerReflection\DTOs\{PriceDto, BioDto, BankDto, CityDto, VillageDto, SubdistrictDto, ProvinceDto, VehicleDto};

enum ProviderResource: string
{
    case PRICE = 'resources/provider/price';
    case BIO = 'resources/provider/bio';
    case BANK = 'resources/provider/bank';
    case CITY = 'resources/provider/city';
    case VILLAGE = 'resources/provider/village';
    case SUBDISTRICT = 'resources/provider/subdistrict';
    case PROVINCE = 'resources/provider/province';
    case VEHICLE = 'resources/provider/vehicle';

    public function getDtoClass(): string
    {
        return match ($this) {
            self::PRICE => PriceDto::class,
            self::BIO => BioDto::class,
            self::BANK => BankDto::class,
            self::CITY => CityDto::class,
            self::VILLAGE => VillageDto::class,
            self::SUBDISTRICT => SubdistrictDto::class,
            self::PROVINCE => ProvinceDto::class,
            self::VEHICLE => VehicleDto::class,
        };
    }

    public function getPath(): string
    {
        return getenv('PROJECT_DIR') . "/{$this->value}.json";
    }
}
