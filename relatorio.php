<?php
require_once 'config/conexao.php';

try {
    $stmtTotal = $pdo->query("SELECT COUNT(*) AS total FROM votos");
    $totalVotos = $stmtTotal->fetch()['total'];

    $sqlRelatorio = "
        SELECT 
            c.codigo_chapa,
            c.nome_chapa,
            c.nome_lider,
            c.nome_vice,
            COUNT(v.id) AS total_votos
        FROM chapas c
        LEFT JOIN votos v ON c.id = v.chapa_id
        GROUP BY c.id
        ORDER BY total_votos DESC, c.codigo_chapa ASC
    ";
    
    $stmtRelatorio = $pdo->query($sqlRelatorio);
    $relatorio = $stmtRelatorio->fetchAll();

} catch (PDOException $e) {
    die("Erro ao gerar relatório: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório da Votação - Eleição de Líder</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f4f4f9; }
        .container { max-width: 850px; margin: auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; color: #333; }
        .card-total { background-color: #0056b3; color: white; padding: 15px 20px; border-radius: 6px; margin-bottom: 25px; font-size: 18px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; color: #333; border-bottom: 2px solid #dee2e6; }
        tr:hover { background-color: #f1f1f1; }
        .barra-progresso-container { background-color: #e9ecef; border-radius: 4px; height: 18px; width: 100%; overflow: hidden; margin-top: 5px; }
        .barra-progresso { background-color: #28a745; height: 100%; text-align: center; color: white; font-size: 11px; line-height: 18px; font-weight: bold; }
        .nav { margin-bottom: 20px; }
        .nav a { text-decoration: none; color: #0056b3; font-weight: bold; }
        .alerta-vazio { padding: 15px; background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; border-radius: 4px; }
    </style>
</head>
<body>

<div class="container">
    <div class="nav">
        <a href="index.php">← Voltar ao Menu Principal</a> | 
        <a href="votacao.php">Ir para Tela de Votação</a>
    </div>

    <h2>Relatório e Apuração da Votação</h2>

    <div class="card-total">
        <strong>Total Geral de Votos Registrados:</strong> <?= $totalVotos ?> voto(s)
    </div>

    <?php if (count($relatorio) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Chapa</th>
                    <th>Líder / Vice-Líder</th>
                    <th>Votos</th>
                    <th style="width: 30%;">Representatividade (%)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($relatorio as $linha): ?>
                    <?php 
                        // Cálculo do percentual de representatividade usando $linha['total_votos']
                        $percentual = $totalVotos > 0 ? ($linha['total_votos'] / $totalVotos) * 100 : 0;
                        $percentualFormatado = number_format($percentual, 2, ',', '.');
                    ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($linha['codigo_chapa']) ?></strong><br>
                            <small><?= htmlspecialchars($linha['nome_chapa']) ?></small>
                        </td>
                        <td>
                            Líder: <?= htmlspecialchars($linha['nome_lider']) ?><br>
                            <small>Vice: <?= htmlspecialchars($linha['nome_vice']) ?></small>
                        </td>
                        <td><strong><?= $linha['total_votos'] ?></strong></td>
                        <td>
                            <div><strong><?= $percentualFormatado ?>%</strong></div>
                            <div class="barra-progresso-container">
                                <div class="barra-progresso" style="width: <?= number_format($percentual, 2, '.', '') ?>%;"></div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alerta-vazio">
            Nenhuma chapa cadastrada para exibir relatório.
        </div>
    <?php endif; ?>
</div>

</body>
</html>