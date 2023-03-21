<?php

declare(strict_types=1);

namespace App\Tests\ProductManagement\DomainModel;

use App\ProductManagement\DomainModel\ProductDescription;
use PHPUnit\Framework\TestCase;

class ProductDescriptionTest extends TestCase
{
    public function testShouldNotThrowExceptionWhenDescriptionIsLongEnough(): void
    {
        $this->expectNotToPerformAssertions();

        new ProductDescription('abc');
    }

    public function testShouldThrowExceptionWhenDescriptionIsEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Product description cannot be empty');

        new ProductDescription('');
    }

    public function testShouldThrowExceptionWhenDescriptionIsTooLong(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Product description cannot be longer than 255 characters');

        new ProductDescription(str_repeat('a', 256));
    }
}
