<?php

declare(strict_types=1);

namespace App\Cart\UserInterface\Cli;

use App\Cart\Application\CreateCart;
use App\Cart\Shared\CartId;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateCartCommand extends Command
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('tidio:carts:create')
            ->setDescription('Creates a new cart');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $cartId = CartId::generate();
        $io = new SymfonyStyle($input, $output);

        $this->messageBus->dispatch(new CreateCart($cartId));

        $io->success(sprintf('Cart created with id: %s', $cartId));
        $io->info([
            'You can add items to this cart using the following command:',
            sprintf('bin/console tidio:carts:add-item %s', $cartId),
        ]);

        return Command::SUCCESS;
    }
}
