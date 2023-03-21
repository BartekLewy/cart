<?php

declare(strict_types=1);

namespace App\Cart\UserInterface\Cli;

use App\Cart\Application\GetCart;
use App\Cart\ReadModel\CartItem;
use App\Cart\Shared\CartId;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class GetCartCommand extends Command
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
        parent::__construct();
    }

    public function configure()
    {
        $this
            ->setName('tidio:carts:get')
            ->setDescription('Get cart')
            ->addArgument('cartId')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $cartId = new CartId($input->getArgument('cartId'));

        $cart = $this
            ->messageBus
            ->dispatch(new GetCart($cartId))
            ->last(HandledStamp::class)
            ->getResult()
        ;

        $io->success(sprintf('Cart with id: %s', $cartId));
        $io->table(['Product', 'Name', 'Quantity', 'Price Net', 'Price Gross', 'VAT'], $this->mapCartItemsToTable($cart->items));
        $io->table(['', 'Value'], [
            ['Total net', $this->formattedPrice($cart->totalPrice)],
            ['Total gross', $this->formattedPrice($cart->totalPriceGross)],
        ]);

        return self::SUCCESS;
    }

    /** @param CartItem[] $items */
    public function mapCartItemsToTable(array $items): array
    {
        $table = [];
        foreach ($items as $item) {
            $table[] = [
                $item->productId,
                $item->name,
                $item->quantity,
                $this->formattedPrice($item->totalPrice),
                $this->formattedPrice($item->totalPriceGross),
                $item->vatRate * 100 .'%',
            ];
        }

        return $table;
    }

    private function formattedPrice(float $price): string
    {
        return number_format($price, 2).' PLN';
    }
}
