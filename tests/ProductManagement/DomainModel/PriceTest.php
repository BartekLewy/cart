<?php

declare(strict_types=1);

namespace App\Tests\ProductManagement\DomainModel;

use App\ProductManagement\DomainModel\Currency;
use App\ProductManagement\DomainModel\Price;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    public function testPriceIsEqualToPriceWithSameValues(): void
    {
        $price = new Price(100, 7, Currency::PLN);
        $price2 = new Price(100, 7, Currency::PLN);

        $this->assertTrue($price->equals($price2));
    }

    /** @dataProvider getPrices */
    public function testPriceIsNotEqualToPriceWithDifferentValues(): void
    {
        $price = new Price(100, 7, Currency::PLN);
        $price2 = new Price(200, 7, Currency::PLN);

        $this->assertFalse($price->equals($price2));
    }

    public function getPrices(): array
    {
        return [
            'values are different' => [
                new Price(100, 7, Currency::PLN),
                new Price(200, 7, Currency::PLN),
            ],
            'vat rates are different' => [
                new Price(100, 7, Currency::PLN),
                new Price(100, 8, Currency::PLN),
            ],
            'currencies are different' => [
                new Price(100, 7, Currency::PLN),
                new Price(100, 7, Currency::EUR),
            ],
        ];
    }
}
