<?php
include("conexao.php");
$dt_local = DateTime::createFromFormat('d-m-Y', date('d-m-Y'));
$dt_inicio = DateTime::createFromFormat('d-m-Y', '13-03-2023');
$dt_fim = DateTime::createFromFormat('d-m-Y', '19-03-2023');


//if ($dt_local < $dt_inicio) {
//    $c_prazo = 'Votações somente serão permitidas no período do dia 13 a 19 DE marco de 2023!!!';
//    header('location: /fundeb/prazo.php?id=' . $c_prazo);
//}

//if ($dt_local > $dt_fim) {
//    $c_prazo = 'Período de votação encerrado!!!';
//   header('location: /fundeb/prazo.php?id=' . $c_prazo);
//}

session_start();
?>

<head>

    <title>PMS - Eleição Conselho Municipal de Saúde</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/yourcode.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

</head>

<body>
    <div class="panel panel-primary class">
        <div class="panel-heading text-center">
            <h4>Conselho Municipal de Saúde</h4>
            <h5>Eleição dos Membros do Conselho Municipal de Saúde<h5>
        </div>
    </div>

    <div class="container -my5">
        <?php
        if (!empty($c_erro)) {
            echo "
            <div class='alert alert-warning' role='alert'>
                <h4>$c_erro</h4>
            </div>
                ";
        }
        ?>
        <form method="post" action="processa_cpf.php">

            <div class="row mb-3">
                <div class="container">
                    <div class="alert alert-success">
                        <strong>Digite o CPF cadastrado para votação e clique em continuar.</strong>
                    </div>
                </div>
                <br>
                <label class="col-sm-2 col-form-label">Informe seu CPF</label>
                <div class="col-sm-2">
                    <input type="text" required maxlength="11" placeholder="apenas números" class="form-control" name="entracpf" value="<?php echo $c_cpf; ?>">
                </div>
            </div>
            <br>

            <nav class="navbar">
                <div class="container-fluid">
                    <br>
                    <button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-circle-arrow-right'></span> Continuar</button>
                    <a class='btn btn-danger' href='/fundeb/index.php'><span class='glyphicon glyphicon-remove'></span> Cancelar</a>

                </div>
            </nav>
        </form>
    </div>
</body>

</html>