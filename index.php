<?php
// controle de acesso ao formulário
//session_start();
//if (!isset($_SESSION['newsession'])) {
//    die('Acesso não autorizado!!!');
//}
//
?>

<!DOCTYPE html>
<html lang="en">

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

    <script>
    </script>
</head>

<body>
    <div class="panel panel-primary class">
        <div class="panel-heading text-center">
            <h4>Conselho Municipal de Saúde</h4>
            <h5>Eleição dos Membros do Conselho Municipal<h5>
        </div>
    </div>

    <div class="container -my5">
        <div class="container">
            <div class="alert alert-success">
                <strong> Prefeitura Municipal de Sabará - Pagina Inicial da plataforma. Clique na opção desejada abaixo.</strong>
            </div>
        </div>

        <div class="panel default class" class="row col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center">
            <div class="panel-heading">
                <img class="rounded mx-auto d-block" class="img-responsive" src="\conselhosaude\img\prefeitura.jpg" class="img-fluid" style="height :100px" style="width:70px">
            </div>
        </div>
        <nav class="navbar ">
            <div class="container-fluid" class="row col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center">
                <br>
                <a id="insc" class="btn btn-success" href="/conselhosaude/segmento.php"><span class="glyphicon glyphicon-edit"></span> Inscrição</a>
                <a id="voto" class="btn btn-primary" href="/conselhosaude/cpf_votacao.php"><span class="glyphicon glyphicon-inbox"></span> Votação</a>
                <a class="btn btn-info " href="/conselhosaude/senha.php"><span class="glyphicon glyphicon-off"></span> Resultados</a>
            </div>
        </nav>


    </div>

</body>

</html>