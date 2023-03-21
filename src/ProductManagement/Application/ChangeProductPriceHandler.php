<?php

declare(strict_types=1);

namespace App\ProductManagement\Application;

use App\Cart\Contracts\RecalculateCartsInterface;
use App\ProductManagement\DomainModel\Price;
use App\ProductManagement\DomainModel\ProductRepositoryInterface;

class ChangeProductPriceHandler
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private RecalculateCartsInterface $recalculateCartsAfterProductPriceChange
    ) {
    }

    public function __invoke(ChangeProductPrice $command): void
    {
        $product = $this->productRepository->get($command->productId);
        $product->changePrice(new Price($command->price, $command->vat));

        $this->productRepository->save($product);

        $this->recalculateCartsAfterProductPriceChange->afterProductPriceChange($command->productId);
    }
}
