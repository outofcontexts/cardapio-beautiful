<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Adicionar Prato</title>
    <link rel="icon" href="/favicon.png" type="image/png" />
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" href="/apple-touch-icon.png" />
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 2em;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }
        h1 {
            color: #333;
            margin-bottom: 1.5em;
            text-align: center;
        }
        form {
            background: #fff;
            border: 1px solid #ddd;
            padding: 25px 30px;
            border-radius: 8px;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
            color: #555;
            margin-bottom: 0.4em;
            margin-top: 1em;
        }
        input[type="text"],
        input[type="number"],
        textarea,
        select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            box-sizing: border-box;
            width: 100%;
            transition: border-color 0.2s ease;
        }
        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            border-color: #28a745;
            outline: none;
        }
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        button[type="submit"] {
            margin-top: 2em;
            padding: 12px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button[type="submit"]:hover {
            background: #218838;
        }
        p a {
            display: inline-block;
            margin-top: 2em;
            background: #007bff;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.3s ease;
            text-align: center;
            max-width: 150px;
            margin-left: auto;
            margin-right: auto;
        }
        p a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <?php
    $nome = isset($_GET['nome']) ? htmlspecialchars($_GET['nome']) : '';
    $descricao = isset($_GET['descricao']) ? htmlspecialchars($_GET['descricao']) : '';
    $tempo = isset($_GET['tempo']) ? (int) $_GET['tempo'] : '';
    $preco = isset($_GET['preco']) ? htmlspecialchars($_GET['preco']) : '';
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
    ?>

    <h1>Adicionar novo prato</h1>
    <form method="POST" action="salvar.php">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?= $nome ?>" required />

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" required rows="4"><?= $descricao ?></textarea>

        <label for="tempo">Tempo de preparo (min):</label>
        <input type="number" id="tempo" name="tempo" value="<?= $tempo ?>" required />

        <label for="preco">Preço (R$):</label>
        <input type="number" step="0.01" id="preco" name="preco" value="<?= $preco ?>" required />

        <label for="tipo">Tipo:</label>
        <select id="tipo" name="tipo" required>
            <option value="" disabled <?= $tipo === '' ? 'selected' : '' ?>>Selecione o tipo</option>
            <option value="salgado" <?= $tipo === 'salgado' ? 'selected' : '' ?>>Salgado</option>
            <option value="sobremesa" <?= $tipo === 'sobremesa' ? 'selected' : '' ?>>Sobremesa</option>
        </select>

        <button type="submit">Salvar</button>
    </form>
    <p><a href="index.php">Voltar ao cardápio</a></p>
</body>
</html>
