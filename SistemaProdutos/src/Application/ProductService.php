<?php
namespace App\Application;

use App\Domain\Product;
use App\Domain\Contracts\ProductRepositoryInterface;
use App\Infra\ProductValidator;

final class ProductService
{
    private ProductRepositoryInterface $repository;
    private ProductValidator $validator;

    public function __construct(ProductRepositoryInterface $repository, ProductValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create(array $data): ?array
    {
        $errors = $this->validator->validate($data);
        if ($errors !== null) {
            return $errors;
        }

        $id = uniqid('', true);
        $product = new Product(
            $id,
            trim((string)$data['name']),
            (float)$data['price'],
            isset($data['description']) ? trim((string)$data['description']) : null
        );

        $this->repository->save($product);
        return null;
    }

    public function list(): array
    {
        return $this->repository->all();
    }
}