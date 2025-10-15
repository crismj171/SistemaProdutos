<?php
namespace App\Domain;

final class Product
{
    private int $id;
    private string $name;
    private float $price;
    private ?string $description;

    public function __construct(int $id, string $name, float $price, ?string $description = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (int)($data['id'] ?? ''),
            (string)($data['name'] ?? ''),
            (float)($data['price'] ?? 0),
            isset($data['description']) ? (string)$data['description'] : null
        );
    }
}