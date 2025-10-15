<?php
namespace App\Infra;

use App\Domain\Product;
use App\Domain\Contracts\ProductRepositoryInterface;

final class FileProductRepository implements ProductRepositoryInterface
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
        }
    }

    /** @return Product[] */
    public function all(): array
    {
        $contents = @file_get_contents($this->filePath) ?: '[]';
        $items = json_decode($contents, true);
        if (!is_array($items)) {
            return [];
        }
        $products = [];
        foreach ($items as $item) {
            try {
                $products[] = Product::fromArray($item);
            } catch (\Throwable $e) {}
        }
        return $products;
    }

    public function save(Product $product): void
    {
        $fp = fopen($this->filePath, 'c+');
        if ($fp === false) {
            throw new \RuntimeException('Não foi possível abrir arquivo de persistência');
        }
        try {
            flock($fp, LOCK_EX);
            $raw = stream_get_contents($fp) ?: '';
            $items = [];
            if ($raw !== '') {
                $decoded = json_decode($raw, true);
                if (is_array($decoded)) {
                    $items = $decoded;
                }
            }
            $items[] = $product->toArray();
            ftruncate($fp, 0);
            rewind($fp);
            fwrite($fp, json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            fflush($fp);
            flock($fp, LOCK_UN);
        } finally {
            fclose($fp);
        }
    }
}