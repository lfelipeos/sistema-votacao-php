# Sistema de Votação On-line (Eleição de Líder de Turma)

Aplicação web desenvolvida em **PHP** com **MySQL** para gerenciamento completo de eleições de representante de turma, permitindo o cadastro de chapas concorrentes, consulta detalhada, votação com restrição de voto único por matrícula e apuração automática de resultados em tempo real.

## Funcionalidades

* **Cadastro de Chapas (`cadastro_chapa.php`):** Registro de código identificador único, nome da chapa, matrícula e nome do líder e vice-líder.
* **Consulta de Chapas (`consulta_chapa.php`):** Listagem estruturada com todos os dados das chapas inscritas e data de registro.
* **Votação On-line (`votacao.php`):** Interface para seleção de chapa mediante matrícula do aluno, com bloqueio automático contra votos duplicados (`UNIQUE` no banco e validação no back-end).
* **Relatório e Apuração (`relatorio.php`):** Contabilização do total geral de votos, total individual por chapa via `LEFT JOIN` e cálculo dinâmico do percentual de representatividade com barras de progresso.

## Tecnologias Utilizadas

* **Back-end:** PHP 8+ (PDO — *PHP Data Objects*)
* **Banco de Dados:** MySQL / MariaDB
* **Front-end:** HTML5, CSS3 (Grid Layout & Flexbox)
* **Segurança:** Prepared Statements (prevenção contra SQL Injection) e sanitização com `htmlspecialchars` (prevenção contra XSS)

## Estrutura de Arquivos

```text
sistemaVotação/
├── config/
│   └── conexao.php          # Configuração da conexão PDO com o MySQL
├── sql/
│   └── script.sql           # DDL para criação do banco votacao_db e tabelas
├── index.php                # Menu principal de navegação
├── cadastro_chapa.php       # Formulário e lógica de cadastro de chapas
├── consulta_chapa.php       # Tabela de visualização das chapas cadastradas
├── votacao.php              # Tela de votação com validação de matrícula única
├── relatorio.php            # Apuração de votos e percentual de representatividade
└── README.md                # Documentação do projeto
```

## Como Executar Localmente

1. **Pré-requisitos:**
   * Tenha o **XAMPP** (ou outro ambiente com PHP e MySQL) instalado e inicie o serviço **MySQL**.

2. **Configurar o Banco de Dados:**
   * Abra seu cliente SQL de preferência (**DBeaver**, phpMyAdmin ou MySQL Workbench).
   * Execute o script localizado em `sql/script.sql` para criar o banco `votacao_db` e as tabelas `chapas` e `votos`.

3. **Configurar a Conexão (se necessário):**
   * Verifique as credenciais em `config/conexao.php` (por padrão configurado para `host: localhost`, `user: root`, `password: ""`).

4. **Iniciar o Servidor:**
   * No terminal, dentro da pasta raiz do projeto, execute o servidor embutido do PHP:
     ```bash
     php -S localhost:8000
     ```
   * Acesse no navegador: `http://localhost:8000`
