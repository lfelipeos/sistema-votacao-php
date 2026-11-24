<?php
require_once __DIR__ . '/config/conexao.php';

try {
    $sql = "SELECT * FROM chapas ORDER BY codigo_chapa ASC";
    $stmt = $pdo->query($sql);
    $chapas = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao consultar chapas: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Chapas - Eleições de Líder</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 30px;}
        .container { max-width: 900px; margin: auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        h2 { margin-top: 0; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #0056b3; color: white; }
        tr:hover { background-color: #f1f1f1; }
        .nav { margin-bottom: 20px; }
        .nav a { text-decoration: none; color: #0056b3; font-weight: bold; }
        .alerta-vazio { padding: 15px; background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; border-radius: 4px; margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <div class="nav">
        <a href="index.php">← Voltar ao Menu Principal</a> | 
        <a href="cadastro_chapa.php">+ Cadastrar Nova Chapa</a>
    </div>

    <h2>Consulta de Chapas Concorrentes</h2>

    <?php if (count($chapas) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nome da Chapa</th>
                    <th>Líder (Matrícula)</th>
                    <th>Vice-Líder (Matrícula)</th>
                    <th>Data de Registo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chapas as $chapa): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($chapa['codigo_chapa']) ?></strong></td>
                        <td><?= htmlspecialchars($chapa['nome_chapa']) ?></td>
                        <td><?= htmlspecialchars($chapa['nome_lider']) ?> (<?= htmlspecialchars($chapa['matricula_lider']) ?>)</td>
                        <td><?= htmlspecialchars($chapa['nome_vice']) ?> (<?= htmlspecialchars($chapa['matricula_vice']) ?>)</td>
                        <td><?= date('d/m/Y H:i', strtotime($chapa['criado_em'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alerta-vazio">
            Nenhuma chapa registada até ao momento. <a href="cadastro_chapa.php">Clica aqui para cadastrar a primeira chapa.</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>