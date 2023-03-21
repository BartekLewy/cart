<?php

declare(strict_types=1);

namespace App\Cart\UserInterface\Cli;

use App\Cart\Application\AddCartItemToCart;
use App\Cart\ReadModel\Product;
use App\Cart\ReadModel\ProductRepositoryInterface;
use App\Cart\Shared\CartId;
use App\Cart\Shared\ProductId;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class AddToCartCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly ProductRepositoryInterface $productRepository
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('tidio:carts:add-item')
            ->setDescription('Adds an item to a cart')
            ->addArgument('cart-id', InputArgument::REQUIRED, 'Cart id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $cartId = new CartId($input->getArgument('cart-id'));

        $productId = $this->chooseProduct($io);

        $this->messageBus->dispatch(new AddCartItemToCart($cartId, $productId));

        $io->success(sprintf('Item added to cart with id: %s', $cartId));

        return self::SUCCESS;
    }

    private function chooseProduct(SymfonyStyle $io): ProductId
    {
        $products = $this->productRepository->getAll();
        $productId = $io->choice('Choose product', $this->transformProductsToChoices($products));

        return new ProductId($productId);
    }

    private function transformProductsToChoices(array $products): array
    {
        return array_reduce(
            $products,
            function (array $choices, Product $product) {
                $choices[$product->id->id()] = $product->name.' - '.$product->price.' PLN';

                return $choices;
            },
            []
        );
    }
}
