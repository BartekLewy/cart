<?php

declare(strict_types=1);

namespace App\ProductManagement\Infrastructure\Persistence\Type;

use App\ProductManagement\Shared\CategoryId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

class CategoryIdType extends Type
{
    public const NAME = 'category_id';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if (null === $value) {
            return null;
        }

        try {
            return new CategoryId($value);
        } catch (\Throwable) {
            throw ConversionException::conversionFailed($value, self::NAME);
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if (null === $value) {
            return null;
        }

        if (!($value instanceof CategoryId)) {
            throw ConversionException::conversionFailedInvalidType($value, 'string', ['null', CategoryId::class]);
        }

        return $value->id();
    }
}
