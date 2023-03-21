<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use App\Cart\Application\AddCartItemToCart;
use App\Cart\Application\CreateCart;
use App\Cart\Application\GetCart;
use App\Cart\ReadModel\Cart;
use App\Cart\Shared\CartId;
use App\Cart\Shared\ProductId;
use App\ProductManagement\Application\ChangeProductPrice;
use App\ProductManagement\Shared\ProductId as ProductIdFromPM;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

use function PHPUnit\Framework\assertSame;

class CartTestWithProductPriceChangingIntegrationTest extends KernelTestCase
{
    public const PRODUCT_1_ID = '00000000-0000-0000-0000-000000000000';
    public const PRODUCT_2_ID = '00000000-0000-0000-0000-000000000001';
    public const PRODUCT_3_ID = '00000000-0000-0000-0000-000000000002';

    private ?MessageBusInterface $messageBus = null;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $this->messageBus = $container->get(MessageBusInterface::class);
    }

    public function testFlowFromTask(): void
    {
        $cartId = CartId::generate();
        $this->messageBus->dispatch(new CreateCart($cartId));
        $this->messageBus->dispatch(new AddCartItemToCart($cartId, new ProductId(self::PRODUCT_1_ID)));
        $this->messageBus->dispatch(new AddCartItemToCart($cartId, new ProductId(self::PRODUCT_2_ID)));
        $this->messageBus->dispatch(new AddCartItemToCart($cartId, new ProductId(self::PRODUCT_1_ID)));
        $this->messageBus->dispatch(new AddCartItemToCart($cartId, new ProductId(self::PRODUCT_3_ID)));
        $this->messageBus->dispatch(
            new ChangeProductPrice(new ProductIdFromPM(self::PRODUCT_3_ID), 32.71, 0.07)
        );

        /** @var Cart $cart */
        $cart = $this->messageBus->dispatch(new GetCart($cartId))->last(HandledStamp::class)->getResult();

        assertSame(97.19, $cart->totalPrice);
        assertSame(103.99, $cart->totalPriceGross);

        foreach ($cart->items as $item) {
            if (self::PRODUCT_1_ID == $item->productId) {
                assertSame(2, $item->quantity);
                assertSame(37.38, $item->totalPrice);
                assertSame(40.00, $item->totalPriceGross);
            }
            if (self::PRODUCT_2_ID == $item->productId) {
                assertSame(1, $item->quantity);
                assertSame(27.10, $item->totalPrice);
                assertSame(29.00, $item->totalPriceGross);
            }
            if (self::PRODUCT_3_ID == $item->productId) {
                assertSame(1, $item->quantity);
                assertSame(32.71, $item->totalPrice);
                assertSame(35.00, $item->totalPriceGross);
            }
        }
    }
}
