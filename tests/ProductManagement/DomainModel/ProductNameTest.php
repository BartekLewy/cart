<?php

declare(strict_types=1);

namespace App\Tests\ProductManagement\DomainModel;

use App\ProductManagement\DomainModel\ProductName;
use PHPUnit\Framework\TestCase;

class ProductNameTest extends TestCase
{
    public function testShouldNotThrowExceptionWhenNameIsLongEnough(): void
    {
        $this->expectNotToPerformAssertions();

        new ProductName('abc');
    }

    public function testShouldThrowExceptionWhenNameIsTooShort(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Product name must be at least 3 characters long');

        new ProductName('ab');
    }
}
