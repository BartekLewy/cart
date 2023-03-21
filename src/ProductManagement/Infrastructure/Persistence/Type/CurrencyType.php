<?php

namespace App\ProductManagement\Infrastructure\Persistence\Type;

use App\ProductManagement\DomainModel\Currency;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class CurrencyType extends Type
{
    public const NAME = 'currency';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'TEXT';
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value?->value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        return Currency::from($value);
    }
}
