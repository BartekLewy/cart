<?php

declare(strict_types=1);

namespace App\Cart\UserInterface\Cli;

use App\Cart\Application\RemoveCartItemFromCart;
use App\Cart\Shared\CartId;
use App\Cart\Shared\ProductId;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class RemoveFromCartCommand extends Command
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
        parent::__construct();
    }

    public function configure(): void
    {
        $this
            ->setName('tidio:carts:remove')
            ->setDescription('Remove product from cart')
            ->addArgument('cartId')
            ->addArgument('productId')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $cartId = new CartId($input->getArgument('cartId'));
        $productId = new ProductId($input->getArgument('productId'));

        $this->messageBus->dispatch(new RemoveCartItemFromCart($cartId, $productId));

        $io->success(sprintf('Item removed from cart with id: %s', $cartId));

        return self::SUCCESS;
    }
}
