<?php

declare(strict_types=1);

namespace App\Cart\UserInterface\Cli;

use App\Cart\Application\ChangeCartItemQuantity;
use App\Cart\Shared\CartId;
use App\Cart\Shared\ProductId;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class ChangeItemQuantityCommand extends Command
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
        parent::__construct();
    }

    public function configure(): void
    {
        $this
            ->setName('tidio:carts:change')
            ->setDescription('Change item quantity in cart')
            ->addArgument('cartId')
            ->addArgument('productId')
            ->addArgument('quantity');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        if (!$input->getArgument('cartId') || !$input->getArgument('productId') || !$input->getArgument('quantity')) {
            $io->error('Missing arguments');

            return self::FAILURE;
        }

        $cartId = new CartId($input->getArgument('cartId'));
        $productId = new ProductId($input->getArgument('productId'));
        $quantity = (int) $input->getArgument('quantity');

        try {
            $this->messageBus->dispatch(new ChangeCartItemQuantity($cartId, $productId, $quantity));
        } catch (\Exception $e) {
            $io->error($e->getPrevious()->getMessage());

            return self::FAILURE;
        }

        $io->success(sprintf('Item quantity changed in cart with id: %s', $cartId));

        return self::SUCCESS;
    }
}
