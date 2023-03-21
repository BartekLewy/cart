<?php

declare(strict_types=1);

namespace App\ProductManagement\Infrastructure\Read;

use App\ProductManagement\ReadModel\Category;
use App\ProductManagement\ReadModel\CategoryRepositoryInterface;
use App\ProductManagement\Shared\CategoryId;
use Doctrine\DBAL\Connection;

class DbalCategoryRepository implements CategoryRepositoryInterface
{
    public function __construct(
        private readonly Connection $connection
    ) {
    }

    /** @return Category[] */
    public function getAll(): array
    {
        $categories = $this
            ->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'name',
            )
            ->from('categories')
            ->executeQuery()
            ->fetchAllAssociative()
        ;

        return $this->mapCategories($categories);
    }

    /** @return Category[] */
    private function mapCategories(array $categories): array
    {
        return array_map(fn (array $category): Category => $this->mapCategory($category), $categories);
    }

    private function mapCategory(array $category): Category
    {
        return new Category(
            new CategoryId($category['id']),
            $category['name'],
        );
    }
}
