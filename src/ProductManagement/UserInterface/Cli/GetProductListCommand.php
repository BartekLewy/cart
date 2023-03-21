<?php

declare(strict_types=1);

namespace App\ProductManagement\UserInterface\Cli;

use App\ProductManagement\Application\GetCategories;
use App\ProductManagement\Application\GetProducts;
use App\ProductManagement\ReadModel\Category;
use App\ProductManagement\ReadModel\Product;
use App\ProductManagement\Shared\CategoryId;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

class GetProductListCommand extends Command
{
    public function __construct(
        private readonly GetCategories $categories,
        private readonly GetProducts $products,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('tidio:products:list')
            ->setDescription('List of all products')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $category = $io->askQuestion($this->chooseCategory());
        $products = 0 == $category
            ? $this->products->getAll()
            : $this->products->getAllByCategoryId(new CategoryId($category));

        $io->table(['ID', 'name', 'description', 'net', 'gross', 'vat'], $this->mapProductsToTable($products));

        return self::SUCCESS;
    }

    private function chooseCategory(): ChoiceQuestion
    {
        return new ChoiceQuestion(
            'From which category do you want to see products?',
            $this->transformCategoriesToChoices($this->categories->getAll())
        );
    }

    private function transformCategoriesToChoices(array $categories): array
    {
        return array_merge(['All'], array_reduce(
            $categories,
            function (array $choices, Category $category) {
                $choices[$category->id->id()] = $category->name;

                return $choices;
            },
            []
        ));
    }

    /** @param Product[] $products */
    private function mapProductsToTable(array $products): array
    {
        $table = [];
        foreach ($products as $product) {
            $table[] = [
                $product->id,
                $product->name,
                $product->description,
                $this->formattedPrice($product->price),
                $this->formattedPrice($product->price + $product->price * $product->vat),
                $product->vat * 100 .'%',
            ];
        }

        return $table;
    }

    private function formattedPrice(float $price): string
    {
        return number_format($price, 2).' PLN';
    }
}
