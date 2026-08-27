<?php
include("../conexao.php");
// montagem de sql para apuração de votos por segmento na tabela votos, considerando o campo id_candidato e id_eleitor, agrupando por segmento e candidato, e contando os votos
$sql = "SELECT count(votos.id) as votos, cadastro.SUS_NOME AS cadidato_sus, cadastro.CATEGORIA FROM votos 
JOIN cadastro ON votos.id_candidato=cadastro.ID
WHERE cadastro.CATEGORIA=1
GROUP BY  votos.id_candidato";
$result = $conection->query($sql);
$registro = $result->fetch_assoc();


// Substitua os valores abaixo pelos resultados apurados no banco de dados.
// Para cada segmento, você deve consultar o banco de dados e preencher os arrays com os candidatos e seus respectivos votos.
// loop para cada segmento e candidato, preenchendo o array $segmentos com os resultados
foreach ($result as $row) {
    $segmento = '';
    switch ($row['CATEGORIA']) {
        case 1:
            $segmento = 'Eleitor SUS';
            break;
        case 2:
            $segmento = 'Trabalhador SUS';
            break;
        case 3:
            $segmento = 'ONGs';
            break;
    }
    if (!isset($segmentos[$segmento])) {
        $segmentos[$segmento] = [];
    }
    $segmentos[$segmento][] = [
        'candidato' => $row['cadidato_sus'],
        'votos' => $row['votos']
    ];
}
// monto o array de cores para os gráficos, e calculo o total de votos por segmento e o total geral



$cores = ['#2563eb', '#16a34a', '#f59e0b', '#dc2626', '#7c3aed', '#0891b2'];
$totais = [];
foreach ($segmentos as $nome => $resultados) {
    $totais[$nome] = array_sum(array_column($resultados, 'votos'));
}
$totalGeral = array_sum($totais);
?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resultado da Eleição | Conselho de Saúde</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #123c69;
            --bg: #f3f6fa;
            --text: #1f2937;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: var(--text);
            background: var(--bg);
        }

        header {
            background: var(--primary);
            color: #fff;
            padding: 30px 5%;
        }

        header h1 {
            margin: 0 0 8px;
            font-size: clamp(1.5rem, 3vw, 2.2rem);
        }

        header p {
            margin: 0;
            opacity: .85;
        }

        main {
            max-width: 1200px;
            margin: 28px auto;
            padding: 0 18px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 16px;
            margin-bottom: 22px;
        }

        .card,
        .panel {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px #17255412;
        }

        .card small {
            color: #64748b;
            display: block;
            margin-bottom: 8px;
        }

        .card strong {
            font-size: 1.8rem;
            color: var(--primary);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(330px, 1fr));
            gap: 20px;
        }

        .panel h2 {
            font-size: 1.15rem;
            margin: 0 0 18px;
            color: var(--primary);
        }

        .chart-wrap {
            height: 270px;
            position: relative;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: left;
            padding: 11px 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            color: #64748b;
            font-size: .85rem;
        }

        td:last-child,
        th:last-child {
            text-align: right;
        }

        .percent {
            color: #64748b;
            font-size: .9rem;
        }

        footer {
            text-align: center;
            color: #64748b;
            padding: 25px;
            font-size: .85rem;
        }
    </style>
</head>

<body>
    <header>
        <h1>Resultado da Eleição</h1>
        <p>Conselho Municipal de Saúde · Apuração por segmento</p>
    </header>
    <main>
        <section class="cards">
            <div class="card"><small>Total de votos</small><strong><?= number_format($totalGeral, 0, ',', '.') ?></strong></div>
            <?php foreach ($totais as $nome => $total): ?>
                <div class="card"><small><?= htmlspecialchars($nome) ?></small><strong><?= number_format($total, 0, ',', '.') ?></strong></div>
            <?php endforeach; ?>
        </section>



        <section class="grid">
            <?php foreach ($segmentos as $nome => $resultados):
                $total = $totais[$nome];
                $id = 'chart_' . substr(md5($nome), 0, 8);
            ?>
                <article class="panel">
                    <h2><?= htmlspecialchars($nome) ?></h2>
                    <div class="chart-wrap"><canvas id="<?= $id ?>"></canvas></div>
                    <table>
                        <thead>
                            <tr>
                                <th>Candidato</th>
                                <th>Votos</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultados as $resultado): $percentual = $total ? ($resultado['votos'] / $total) * 100 : 0; ?>
                                <tr>
                                    <td><?= htmlspecialchars($resultado['candidato']) ?></td>
                                    <td><?= number_format($resultado['votos'], 0, ',', '.') ?></td>
                                    <td class="percent"><?= number_format($percentual, 1, ',', '.') ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </article>
            <?php endforeach; ?>
        </section>
    </main>
    <footer>Dados apresentados conforme a apuração registrada.</footer>

</body>

</html>