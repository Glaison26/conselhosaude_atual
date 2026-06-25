<?php

session_start();
$escolha = @$_POST['segmento'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //

    if (empty($escolha)) {
        echo '
        <script>alert("Nenhum tipo foi selecionado");</script>';
    } else {
        $_SESSION['c_segmento'] = $_POST['segmento'];
        header('location: /conselhosaude/tipo_membro.php');
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/jquery-1.2.6.pack.js"></script>
    <script type="text/javascript" src="js/jquery.maskedinput-1.1.4.pack.js"></script>


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
                <strong>Selecione o tipo de cadastro e depois clique em continuar </strong>
            </div>
        </div>
        <form method="post">
            <br>
            <div class="row mb-3">
                <div class="col-sm-6 col-form-label">
                    <p>
                    <h5>Qual o tipo de Cadastro?</h5>
                    </p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="segmento" id="seg1" Value="1">
                        <label class="form-check-label" for="seg1">
                            1. Cadastro para usuários do SUS
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="segmento" id="seg2" Value="2">
                        <label class="form-check-label" for="seg2">
                            2. Cadastro para trabalhadores do SUS
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="segmento" id="seg3" Value="3">
                        <label class="form-check-label" for="seg3">
                            3. Cadastro para Organizações não governamentais
                        </label>
                    </div>

                </div>
            </div>
            <hr>
            <div class="row mb-3">
                <nav class="navbar ">
                    <div class="container-fluid">
                        <button name="btncontinua" type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-circle-arrow-right'></span> Continuar</button>
                        <a class='btn btn-danger' href='/conselhosaude/index.php'><span class='glyphicon glyphicon-remove'></span> Cancelar</a>
                    </div>
                </nav>
            </div>
        </form>
    </div>
    <br>



</body>

</html>