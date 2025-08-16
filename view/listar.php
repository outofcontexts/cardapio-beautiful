<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cardápio do Restaurante</title>
    <link rel="icon" href="../favicon.png" type="image/png">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 2em;
            background-color: #f9f9f9;
        }
        h1, h2 {
            color: #333;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background: #fff;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 5px;
        }
        a {
            display: inline-block;
            margin-bottom: 20px;
            background: #28a745;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
        }
        a:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <h1>Cardápio</h1>
    <a href="../adicionar.php">Adicionar novo prato</a>

    <?php if (!empty($pratos)): ?>
        <h2>Pratos Salgados</h2>
        <ul>
            <?php foreach ($pratos as $prato): ?>
                <?php if ($prato->tipo === 'salgado'): ?>
                    <li>
                        <strong><?= htmlspecialchars($prato->nome) ?></strong><br>
                        <?= nl2br(htmlspecialchars($prato->descricao)) ?><br>
                        Tempo: <?= (int)$prato->tempo_preparo ?> min<br>
                        Preço: R$ <?= number_format($prato->preco, 2, ',', '.') ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>

        <h2>Sobremesas</h2>
        <ul>
            <?php foreach ($pratos as $prato): ?>
                <?php if ($prato->tipo === 'sobremesa'): ?>
                    <li>
                        <strong><?= htmlspecialchars($prato->nome) ?></strong><br>
                        <?= nl2br(htmlspecialchars($prato->descricao)) ?><br>
                        Tempo: <?= (int)$prato->tempo_preparo ?> min<br>
                        Preço: R$ <?= number_format($prato->preco, 2, ',', '.') ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Nenhum prato cadastrado.</p>
    <?php endif; ?>
</body>
</html>
