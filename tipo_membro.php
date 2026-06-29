<?php
session_start();
$escolha = @$_POST['tipo'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (empty($escolha)) {
        echo '
        <script>alert("Nenhum tipo foi selecionado");</script>';
    } else {
        $_SESSION['c_tipo'] = $_POST['tipo'];
        header('location: /conselhosaude/entracpf.php');
    }
}

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

</head>

<body>
    <div class="panel panel-primary class">
        <div class="panel-heading text-center">
            <h4>Conselho Municipal de Saúde</h4>
            <h5>Eleição dos Membros do Conselho Municipal<h5>
        </div>
    </div>
    <div class="container -my5">
        <div class="row mb-3" class="container">
            <div class="alert alert-success">
                <strong>Selecione se voçê é Eleitor ou Candidato / Eleitor e clique em continuar. </strong>
            </div>
        </div>
        <form method="post">
            <div class="row mb-3">
                <div class="col-sm-6 col-form-label">
                    <p>
                    <h5>Você é :</h5>
                    </p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipo" required id="tipoeleitor" Value="Eleitor">
                        <label class="form-check-label" for="tipoeleitor">
                            Eleitor
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipo" id="tipocandidato" value="Candidato">
                        <label class="form-check-label" for="tipocandidato">
                            Candidato / Eleitor
                        </label>
                    </div>
                </div>
            </div>
            <br>
            <div class="row mb-3">
                <nav class="navbar ">
                    <div class="container-fluid">
                        <br>
                        <button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-circle-arrow-right'></span> Continuar</button>
                        <a class='btn btn-danger' href='/conselhosaude/index.php'><span class='glyphicon glyphicon-remove'></span> Cancelar</a>

                    </div>
                </nav>
            </div>
        </form>
    </div>
</body>

</html>