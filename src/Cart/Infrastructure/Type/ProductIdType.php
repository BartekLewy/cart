<?php

declare(strict_types=1);

namespace App\Cart\Infrastructure\Type;

use App\Cart\Shared\ProductId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

class ProductIdType extends Type
{
    public const NAME = 'cart_product_id';

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
            return new ProductId($value);
        } catch (\Throwable) {
            throw ConversionException::conversionFailed($value, self::NAME);
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if (null === $value) {
            return null;
        }

        if (!($value instanceof ProductId)) {
            throw ConversionException::conversionFailedInvalidType($value, 'string', ['null', ProductId::class]);
        }

        return $value->id();
    }
}
