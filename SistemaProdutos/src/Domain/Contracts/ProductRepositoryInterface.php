<?php
namespace App\Domain\Contracts;

use App\Domain\Product;

interface ProductRepositoryInterface
{
    /** @return Product[] */
    public function all(): array;

    public function save(Product $product): void;
}