<?php
require_once __DIR__ . '/config/conexao.php';

$mensagem = '';
$tipoMensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigoChapa = trim($_POST['codigo_chapa']);
    $nomeChapa = trim($_POST['nome_chapa']);
    $matriculaLider = trim($_POST['matricula_lider']);
    $nomeLider = trim($_POST['nome_lider']);
    $matriculaVice = trim($_POST['matricula_vice']);
    $nomeVice = trim($_POST['nome_vice']);

    if (empty ($codigoChapa) || empty($nomeChapa) || empty($matriculaLider) || empty($nomeLider) || empty($matriculaVice) || empty($nomeVice)) {
        $mensagem = 'Todos os campos são obrigatórios.';
        $tipoMensagem = 'erro';
    } else {
        try {
            $sql = "INSERT INTO chapas (codigo_chapa, nome_chapa, matricula_lider, nome_lider, matricula_vice, nome_vice) VALUES (:codigo_chapa, :nome_chapa, :matricula_lider, :nome_lider, :matricula_vice, :nome_vice)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':codigo_chapa' => $codigoChapa,
                ':nome_chapa' => $nomeChapa,
                ':matricula_lider' => $matriculaLider,
                ':nome_lider' => $nomeLider,
                ':matricula_vice' => $matriculaVice,
                ':nome_vice' => $nomeVice
            ]);
            $mensagem = 'Chapa cadastrada com sucesso!';
            $tipoMensagem = 'sucesso';
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $mensagem = "Código da chapa '$codigoChapa' já existe. Escolha outro código.";                
            } else {
                $mensagem = 'Erro ao cadastrar a chapa: ' . $e->getMessage();
            }
            $tipoMensagem = 'erro';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Chapa - Eleições de Líder</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 30px;}
        .container { max-width: 600px; margin: auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        h2 { margin-top: 0; color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"] { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { background-color: #0056b3; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #003d82; }
        .mensagem { padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        .sucesso { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .erro { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .nav { margin-bottom: 20px; }
        .nav a { text-decoration: none; color: #0056b3; margin-right: 15px; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <div class="nav">
        <a href="index.php">← Voltar ao Menu Principal</a>
    </div>

    <h2>Cadastro de Chapa</h2>

    <!-- Exibe mensagens de sucesso ou erro -->
    <?php if (!empty($mensagem)): ?>
        <div class="mensagem <?= $tipoMensagem ?>">
            <?= htmlspecialchars($mensagem) ?>
        </div>
    <?php endif; ?>

    <form action="cadastro_chapa.php" method="POST">
        <div class="form-group">
            <label for="codigo_chapa">Código da Chapa (ex: CHAPA-01):</label>
            <input type="text" id="codigo_chapa" name="codigo_chapa" required>
        </div>

        <div class="form-group">
            <label for="nome_chapa">Nome da Chapa:</label>
            <input type="text" id="nome_chapa" name="nome_chapa" required>
        </div>

        <hr style="margin: 20px 0;">

        <div class="form-group">
            <label for="matricula_lider">Matrícula do Líder:</label>
            <input type="text" id="matricula_lider" name="matricula_lider" required>
        </div>

        <div class="form-group">
            <label for="nome_lider">Nome do Líder:</label>
            <input type="text" id="nome_lider" name="nome_lider" required>
        </div>

        <hr style="margin: 20px 0;">

        <div class="form-group">
            <label for="matricula_vice">Matrícula do Vice-Líder:</label>
            <input type="text" id="matricula_vice" name="matricula_vice" required>
        </div>

        <div class="form-group">
            <label for="nome_vice">Nome do Vice-Líder:</label>
            <input type="text" id="nome_vice" name="nome_vice" required>
        </div>

        <button type="submit">Cadastrar Chapa</button>
    </form>
</div>

</body>
</html>