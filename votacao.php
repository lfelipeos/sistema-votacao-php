<?php
require_once 'config/conexao.php';

$mensagem = '';
$tipoMensagem = '';

try {
    $stmtChapas = $pdo->query("SELECT id, codigo_chapa, nome_chapa, nome_lider, nome_vice FROM chapas ORDER BY codigo_chapa ASC");
    $chapas = $stmtChapas->fetchAll();
} catch (PDOException $e) {
    die("Erro ao consultar chapas: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matriculaAluno = trim($_POST['matricula_aluno']);
    $chapaId = filter_input(INPUT_POST, 'chapa_id', FILTER_VALIDATE_INT);

    if (empty($matriculaAluno) || !$chapaId) {
        $mensagem = 'Por favor, informe a sua matricula e selecione uma chapa antes de votar.';
        $tipoMensagem = 'erro';
    } else {
        try {
            $stmtVerifica = $pdo->prepare("SELECT id FROM votos WHERE matricula_aluno = :matricula_aluno");
            $stmtVerifica->execute([':matricula_aluno' => $matriculaAluno]);
            
            if ($stmtVerifica->fetch()) {
                $mensagem = "Atenção: O aluno com matrícula '$matriculaAluno' já votou. Votos duplicados não são permitidos.";
                $tipoMensagem = 'erro';
            } else {
                $stmtVoto = $pdo->prepare("INSERT INTO votos (matricula_aluno, chapa_id) VALUES (:matricula_aluno, :chapa_id)");
                $stmtVoto->execute([':matricula_aluno' => $matriculaAluno, ':chapa_id' => $chapaId]);
                $mensagem = 'Voto registrado com sucesso!';
                $tipoMensagem = 'sucesso';
            }
        } catch (PDOException $e) {
            $mensagem = 'Erro ao registrar o voto: ' . $e->getMessage();
            $tipoMensagem = 'erro';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Votação - Eleição de Líder</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f4f4f9; }
        .container { max-width: 650px; margin: auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; color: #333; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        input[type="text"] { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; font-size: 15px; }
        .chapa-opcao { border: 1px solid #ddd; border-radius: 6px; padding: 12px; margin-bottom: 10px; cursor: pointer; display: flex; align-items: center; }
        .chapa-opcao:hover { background-color: #f9f9f9; border-color: #0056b3; }
        .chapa-opcao input[type="radio"] { margin-right: 15px; transform: scale(1.2); }
        .chapa-info { line-height: 1.4; }
        button { background-color: #28a745; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; width: 100%; }
        button:hover { background-color: #218838; }
        .mensagem { padding: 12px; margin-bottom: 20px; border-radius: 4px; font-weight: bold; }
        .sucesso { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .erro { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .nav { margin-bottom: 20px; }
        .nav a { text-decoration: none; color: #0056b3; font-weight: bold; }
        .alerta-vazio { padding: 15px; background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; border-radius: 4px; }
    </style>
</head>
<body>

<div class="container">
    <div class="nav">
        <a href="index.php">← Voltar ao Menu Principal</a>
    </div>

    <h2>Votação On-line</h2>

    <?php if (!empty($mensagem)): ?>
        <div class="mensagem <?= $tipoMensagem ?>">
            <?= htmlspecialchars($mensagem) ?>
        </div>
    <?php endif; ?>

    <?php if (count($chapas) > 0): ?>
        <form action="votacao.php" method="POST">
            <div class="form-group">
                <label for="matricula_aluno">Informe a sua Matrícula de Aluno:</label>
                <input type="text" id="matricula_aluno" name="matricula_aluno" placeholder="Ex: 20241010" required>
            </div>

            <div class="form-group">
                <label>Selecione a Chapa em que deseja votar:</label>
                <?php foreach ($chapas as $chapa): ?>
                    <label class="chapa-opcao">
                        <input type="radio" name="chapa_id" value="<?= $chapa['id'] ?>" required>
                        <div class="chapa-info">
                            <strong><?= htmlspecialchars($chapa['codigo_chapa']) ?> - <?= htmlspecialchars($chapa['nome_chapa']) ?></strong><br>
                            <small>Líder: <?= htmlspecialchars($chapa['nome_lider']) ?> | Vice: <?= htmlspecialchars($chapa['nome_vice']) ?></small>
                        </div>
                    </label>
                <?php endforeach; ?>
            </div>

            <button type="submit">Confirmar Voto</button>
        </form>
    <?php else: ?>
        <div class="alerta-vazio">
            Não existem chapas cadastradas para votação. <a href="cadastro_chapa.php">Cadastre uma chapa primeiro.</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>