<?php

declare(strict_types=1);

namespace App\Cart\Infrastructure\Type;

use App\Cart\Shared\CartItemId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

class CartItemIdType extends Type
{
    public const NAME = 'cart_item_id';

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
            return new CartItemId($value);
        } catch (\Throwable) {
            throw ConversionException::conversionFailed($value, self::NAME);
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if (null === $value) {
            return null;
        }

        if (!($value instanceof CartItemId)) {
            throw ConversionException::conversionFailedInvalidType($value, 'string', ['null', CartItemId::class]);
        }

        return $value->id();
    }
}
