<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Votação - Eleição de Líder de Turma</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 40px; background-color: #f4f4f9; }
        .container { max-width: 800px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #0056b3; margin-top: 0; text-align: center; }
        p.subtitulo { text-align: center; color: #666; font-size: 16px; margin-bottom: 30px; }
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; }
        .card-menu { background: #f8f9fa; border: 2px solid #e9ecef; border-radius: 8px; padding: 20px; text-align: center; text-decoration: none; color: #333; transition: all 0.3s ease; }
        .card-menu:hover { border-color: #0056b3; background: #eef5ff; transform: translateY(-3px); }
        .card-menu h3 { margin: 10px 0 5px 0; color: #0056b3; }
        .card-menu p { margin: 0; font-size: 14px; color: #666; }
    </style>
</head>
<body>

<div class="container">
    <h1>Sistema de Eleição On-line</h1>
    <p class="subtitulo">Escolha uma das opções abaixo para navegar pelo sistema:</p>

    <div class="menu-grid">
        <a href="cadastro_chapa.php" class="card-menu">
            <h3>1. Cadastrar Chapa</h3>
            <p>Registar novas chapas com líder e vice-líder.</p>
        </a>

        <a href="consulta_chapa.php" class="card-menu">
            <h3>2. Consultar Chapas</h3>
            <p>Visualizar relatório detalhado das chapas concorrentes.</p>
        </a>

        <a href="votacao.php" class="card-menu">
            <h3>3. Votação On-line</h3>
            <p>Registar o voto do aluno através da matrícula.</p>
        </a>

        <a href="relatorio.php" class="card-menu">
            <h3>4. Relatório Final</h3>
            <p>Acompanhar a apuração de votos e % de representatividade.</p>
        </a>
    </div>
</div>

</body>
</html>