<?php

declare(strict_types=1);

namespace App\ProductManagement\UserInterface\Cli;

use App\ProductManagement\Application\ChangeProductPrice;
use App\ProductManagement\Application\GetProducts;
use App\ProductManagement\Shared\ProductId;
use App\ProductManagement\ReadModel\Product;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class ChangeProductPriceConsole extends Command
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly GetProducts $products,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('tidio:products:change-price')
            ->setDescription('Change product price')
            ->setHelp('This command allows you to change product price');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $product = $io->choice('Which product?', $this->transformProductsToChoices($this->products->getAll()));

        $price = $io->askQuestion(new Question('What is the product price?'));
        $vat = $io->askQuestion(new Question('What is the product VAT?'));

        if (!$product || !$price || !$vat) {
            $io->error('Product ID, price and VAT are required');

            return self::FAILURE;
        }

        $this->messageBus->dispatch(new ChangeProductPrice(
            new ProductId($product),
            (float) $price,
            (float) $vat,
        ));

        $io->info(sprintf('Product %s price changed', $product));

        return self::SUCCESS;
    }

    private function transformProductsToChoices(array $products): array
    {
        return array_reduce(
            $products,
            fn (array $choices, Product $product): array => array_merge(
                $choices,
                [$product->id->id() => sprintf('%s - %s', $product->name, $product->price)]
            ),
            []
        );
    }
}
