<?php
// Ativa todos os erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

// === MODELO ===
class PratoDoCardapio {
    public $id;
    public $nome;
    public $descricao;
    public $tempo_preparo;
    public $preco;
    public $tipo;
}

// === CONEXÃO ===
class ConnectionFactory {
    public static function getConnection() {
        $host = 'localhost';
        $dbname = 'restaurante';
        $user = 'root';
        $pass = '1234';

        try {
            return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }
}

// === DAO ===
class PratoDAO {
    private $conn;

    public function __construct() {
        $this->conn = ConnectionFactory::getConnection();
    }

    public function listarTodos() {
        $stmt = $this->conn->query("SELECT * FROM pratos");
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'PratoDoCardapio');
    }

    public function salvar(PratoDoCardapio $prato) {
        $sql = "INSERT INTO pratos (nome, descricao, tempo_preparo, preco, tipo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $prato->nome,
            $prato->descricao,
            $prato->tempo_preparo,
            $prato->preco,
            $prato->tipo
        ]);
    }
}

// === VALIDAÇÃO ===
function validarDados($dados) {
    $erros = [];

    if (!isset($dados['nome']) || trim($dados['nome']) === '') {
        $erros[] = "Nome é obrigatório.";
    } elseif (!preg_match('/[a-zA-ZÀ-ú\s]/u', $dados['nome'])) {
        $erros[] = "Nome deve conter letras válidas.";
    }

    if (!isset($dados['descricao']) || trim($dados['descricao']) === '') {
        $erros[] = "Descrição é obrigatória.";
    } elseif (!preg_match('/[a-zA-ZÀ-ú\s]/u', $dados['descricao'])) {
        $erros[] = "Descrição deve conter letras válidas.";
    }

    if (!isset($dados['tempo']) || !is_numeric($dados['tempo']) || $dados['tempo'] < 0) {
        $erros[] = "Tempo inválido.";
    }

    if (!isset($dados['preco']) || !is_numeric($dados['preco']) || $dados['preco'] < 0) {
        $erros[] = "Preço inválido.";
    }

    if (!isset($dados['tipo']) || !in_array($dados['tipo'], ['salgado', 'sobremesa'])) {
        $erros[] = "Tipo inválido.";
    }

    return $erros;
}

// === FLUXO PRINCIPAL ===

$dao = new PratoDAO();

// Se for POST, tenta salvar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $erros = validarDados($_POST);

    if ($erros) {
        echo "Erros encontrados:\n";
        foreach ($erros as $erro) {
            echo "- $erro\n";
        }
        exit;
    }

    $prato = new PratoDoCardapio();
    $prato->nome = $_POST['nome'];
    $prato->descricao = $_POST['descricao'];
    $prato->tempo_preparo = (int) $_POST['tempo'];
    $prato->preco = (float) $_POST['preco'];
    $prato->tipo = $_POST['tipo'];

    if ($dao->salvar($prato)) {
        echo "✅ Prato salvo com sucesso.\n";
    } else {
        echo "❌ Erro ao salvar prato.\n";
    }

    exit;
}

// Se GET com parâmetro 'adicionar', exibe instruções de envio
if (isset($_GET['adicionar'])) {
    echo "Para adicionar um prato, envie via POST os seguintes campos:\n";
    echo " - nome\n";
    echo " - descricao\n";
    echo " - tempo (em minutos)\n";
    echo " - preco (ex: 12.50)\n";
    echo " - tipo (salgado ou sobremesa)\n";
    exit;
}

// Senão, listar pratos
$pratos = $dao->listarTodos();

if (!$pratos) {
    echo "Nenhum prato encontrado.\n";
    exit;
}

echo "=== CARDÁPIO ===\n\n";

$salgados = array_filter($pratos, fn($p) => $p->tipo === 'salgado');
$sobremesas = array_filter($pratos, fn($p) => $p->tipo === 'sobremesa');

echo "Salgados:\n";
foreach ($salgados as $p) {
    echo "- {$p->nome} ({$p->tempo_preparo} min, R$ " . number_format($p->preco, 2, ',', '.') . ")\n";
    echo "  {$p->descricao}\n\n";
}

echo "Sobremesas:\n";
foreach ($sobremesas as $p) {
    echo "- {$p->nome} ({$p->tempo_preparo} min, R$ " . number_format($p->preco, 2, ',', '.') . ")\n";
    echo "  {$p->descricao}\n\n";
}
?>