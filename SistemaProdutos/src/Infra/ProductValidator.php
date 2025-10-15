<?php
namespace App\Infra;

final class ProductValidator
{
    public function validate(array $data): ?array
    {
        $errors = [];

        if (!isset($data['name']) || trim($data['name']) === '') {
            $errors['name'] = 'O nome é obrigatório.';
        } elseif (mb_strlen($data['name']) > 191) {
            $errors['name'] = 'O nome é muito longo.';
        }

        if (!isset($data['price']) || trim((string)$data['price']) === '') {
            $errors['price'] = 'O preço é obrigatório.';
        } elseif (!is_numeric($data['price'])) {
            $errors['price'] = 'O preço deve ser numérico.';
        } elseif ((float)$data['price'] < 0) {
            $errors['price'] = 'O preço não pode ser negativo.';
        }

        if (isset($data['description']) && mb_strlen($data['description']) > 1000) {
            $errors['description'] = 'Descrição muito longa.';
        }

        return empty($errors) ? null : $errors;
    }
}