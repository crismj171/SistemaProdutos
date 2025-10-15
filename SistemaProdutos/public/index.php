<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Infra\FileProductRepository;
use App\Infra\ProductValidator;
use App\Application\ProductService;

$storageFile = __DIR__ . '/../storage/products.json';
$repo = new FileProductRepository($storageFile);
$validator = new ProductValidator();
$service = new ProductService($repo, $validator);

$errors = null;
$success = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post = [
        'name' => $_POST['name'] ?? '',
        'price' => $_POST['price'] ?? '',
        'description' => $_POST['description'] ?? null,
    ];

    $errors = $service->create($post);
    if ($errors === null) {
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }
}

$products = $service->list();

?><!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cadastro de Produtos</title>
    <style>
        body{font-family:Arial,Helvetica,sans-serif;max-width:900px;margin:24px auto;padding:0 12px}
        form{margin-bottom:24px}
        label{display:block;margin-top:8px}
        input,textarea{width:100%;padding:8px}
        .errors{color:#b00}
        table{width:100%;border-collapse:collapse}
        th,td{padding:8px;border:1px solid #ddd}
    </style>
</head>
<body>
    <h1>Cadastro de Produtos</h1>

    <?php if ($errors): ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $f => $m): ?>
                    <li><strong><?=htmlspecialchars($f)?>:</strong> <?=htmlspecialchars($m)?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <label>Nome
            <input name="name" required maxlength="191" />
        </label>
        <label>Preço
            <input name="price" required />
        </label>
        <label>Descrição
            <textarea name="description" rows="4"></textarea>
        </label>
        <button type="submit">Cadastrar</button>
    </form>

    <h2>Produtos cadastrados</h2>
    <?php if (empty($products)): ?>
        <p>Nenhum produto cadastrado.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr><th>ID</th><th>Nome</th><th>Preço</th><th>Descrição</th></tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?=htmlspecialchars($p->getId())?></td>
                        <td><?=htmlspecialchars($p->getName())?></td>
                        <td><?=number_format($p->getPrice(),2,',','.')?></td>
                        <td><?=htmlspecialchars($p->getDescription() ?? '')?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>