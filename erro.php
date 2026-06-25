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
    <title>PMS - Eleição Fundeb</title>
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
            <h4>FUNDEB - Fundo de Manutenção e Desenvolvimento da Educação Básica</h4>
            <h5>Eleição dos Membros do Conselho Municipal<h5>
        </div>
    </div>

    <div class="container -my5">
        <div class="container">
            <div class="alert alert-success">
                <strong>Prefeitura Municipal de Sabará </strong>
            </div>
        </div>
        
        <div class="panel default class">
            <div class="panel-heading">
                <img class="img-responsive" src="\fundeb\img\img.jpg" class="img-fluid" style="height :80px" style="width:100px">
            </div>
        </div>

        <div class="container">
            <p>
            <h2 class="text-primary">
                Operação não realizada!! Seus dados já se encontram cadastrados!!<br>
                Caso deseje alterar as informações, clique no botão Alterar dados abaixo e refaça toda a operação!!
            </h2>
            </p>
        </div>
        <nav class="navbar ">
            <div class="container-fluid" class="row col-xs-12 col-sm-12 col-md-12 col-lg-12" align="center">
                <br>
                <a class=" btn btn-success" href="/fundeb/entracpf.php"><span class="glyphicon glyphicon-edit"></span> Alterar Dados</a>
               
            </div>
        </nav>
    </div>

</body>

</html>