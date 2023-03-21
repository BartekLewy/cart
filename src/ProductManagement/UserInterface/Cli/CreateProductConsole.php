<?php

declare(strict_types=1);

namespace App\ProductManagement\UserInterface\Cli;

use App\ProductManagement\Application\AddProduct;
use App\ProductManagement\Application\ChangeProductPrice;
use App\ProductManagement\Application\GetCategories;
use App\ProductManagement\Shared\ProductId;
use App\ProductManagement\ReadModel\Category;
use App\ProductManagement\Shared\CategoryId;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateProductConsole extends Command
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly GetCategories $categories
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('tidio:products:create');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $name = $io->askQuestion(new Question('What is the product name?'));
        $description = $io->askQuestion(new Question('What is the product description?'));
        $categoryId = $io->askQuestion(new ChoiceQuestion(
            'What is the product category?',
            $this->transformCategoriesToChoices($this->categories->getAll())
        ));

        if (!$name || !$description) {
            $io->error('Product name and description are required');

            return self::FAILURE;
        }

        $productId = ProductId::generate();

        $this->messageBus->dispatch(new AddProduct(
            $productId,
            new CategoryId($categoryId),
            $name,
            $description,
        ));

        $io->info(sprintf('Product %s created', $productId));

        $price = $io->askQuestion(new Question('What is the product price?'));
        $vat = $io->askQuestion(new Question('What is the product VAT?'));

        if (!$price || !$vat) {
            $io->error('Product price and VAT are required');

            return self::FAILURE;
        }

        $this->messageBus->dispatch(new ChangeProductPrice(
            $productId,
            (float) $price,
            (float) $vat,
        ));

        return self::SUCCESS;
    }

    private function transformCategoriesToChoices(array $categories): array
    {
        return array_reduce(
            $categories,
            fn (array $choices, Category $category): array => array_merge($choices, [$category->id->id() => $category->name]),
            []
        );
    }
}
