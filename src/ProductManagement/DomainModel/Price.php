<?php

declare(strict_types=1);

namespace App\ProductManagement\DomainModel;

class Price
{
    private float $value;
    private float $vat;
    private Currency $currency;

    public function __construct(float $value, float $vat, Currency $currency = Currency::PLN)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('Price cannot be negative');
        }

        if ($vat < 0) {
            throw new \InvalidArgumentException('VAT cannot be negative');
        }

        $this->value = $value;
        $this->vat = $vat;
        $this->currency = $currency;
    }

    public static function zero(Currency $currency = Currency::PLN): Price
    {
        return new self(0, 0, $currency);
    }

    public function equals(Price $price): bool
    {
        return $this->value === $price->value
            && $this->vat === $price->vat
            && $this->currency === $price->currency
        ;
    }
}
