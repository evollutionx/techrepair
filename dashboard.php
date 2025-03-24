<?php
require_once "classes/login.php";
require_once "classes/db.php";
require_once "classes/dashboard.php";
include "header.php";

date_default_timezone_set('America/Sao_Paulo');
$dashboard = new Dashboard();
$dados_os = $dashboard->getOsPorMes();

$meses = [];
$dados = [];
$statuses = ['aberta', 'concluída', 'cancelada', 'em andamento'];

// Inicializa estrutura de dados
foreach ($statuses as $status) {
    $dados[$status] = array_fill(1, 12, 0);
}

// Preenche os dados com as quantidades retornadas do banco
foreach ($dados_os as $row) {
    $mes = (int) $row['mes'];
    $status = $row['status'];
    $dados[$status][$mes] = $row['quantidade'];
}

$dados_pagamentos = $dashboard->getPagamentosPorMes();

// Organizar os dados para o gráfico
$meses = [];
$valores = [];

foreach ($dados_pagamentos as $pagamento) {
    $meses[] = $pagamento['mes'];
    $valores[] = $pagamento['total'];
}

$pecasEsgotadas = $dashboard->getPecasEsgotadas();

// Converte os dados para formato JSON para uso no JavaScript
$dados_json = json_encode($dados);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechRepair - Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <!-- Gráfico de Ordens de Serviço -->
        <div class="col-md-6 col-12">
            <h2 class="mb-4 text-center">Ordens de Serviço</h2>
            <canvas id="osChart"></canvas>
        </div>

        <!-- Gráfico de Pagamentos -->
        <div class="col-md-6 col-12">
            <h3 class="mb-4 text-center">Recebimentos Mensais</h3>
            <canvas id="graficoPagamentos"></canvas>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Produtos com Estoque Zerado</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($pecasEsgotadas)): ?>
                        <p class="text-muted">Nenhum produto está sem estoque.</p>
                    <?php else: ?>
                        <ul class="list-group">
                            <?php foreach ($pecasEsgotadas as $peca): ?>
                                <li class="list-group-item">
                                    <small class="text-muted"><?php echo htmlspecialchars($peca['nome']); ?></small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById("osChart").getContext("2d");
        const dados = <?php echo $dados_json; ?>;

        const labels = ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"];
        const datasets = [];
        const cores = { 
    'aberta': 'rgb(188, 179, 255)', 
    'em andamento': 'rgb(157, 150, 208)', 
    'concluída': 'rgb(41, 204, 44)', 
    'cancelada': 'rgb(221, 73, 73)' 
};


        for (const status in dados) {
            datasets.push({
                label: status.charAt(0).toUpperCase() + status.slice(1),
                data: Object.values(dados[status]),
                backgroundColor: cores[status],
                borderColor: cores[status],
                borderWidth: 1
            });
        }

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

<script>
    const ctxPagamentos = document.getElementById('graficoPagamentos').getContext('2d');
    
    new Chart(ctxPagamentos, {
        type: 'bar',
        data: {
            labels: <?= json_encode($meses) ?>,
            datasets: [{
                label: 'Total de Pagamentos (R$)',
                data: <?= json_encode($valores) ?>,
                backgroundColor: 'rgb(54, 162, 235)',
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include "footer.php"; ?>
