<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $c_senha = $_POST['senha'];
    $c_erro = '';
    do {
        if ($c_senha != 'sabara@saude2023') {
            $c_erro = 'Senha digitada inválida!!!';
            break;
        }
        header('location: /conselhosaude/lista.php');
    } while (false);
} else {
    $c_senha = '';
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
        <?php
        if (!empty($c_erro)) {
            echo "
            <div class='alert alert-warning' role='alert'>
                <h4>$c_erro</h4>
            </div>
                ";
        }
        ?>
        <form method="post">
            <div class="row mb-3">
                <div class="container">
                    <div class="alert alert-success">
                        <strong>Digite a senha de acesso e clique em continuar </strong>
                    </div>
                </div>
                <br>
                <label class="col-sm-2 col-form-label">Digite a Senha</label>
                <div class="col-sm-2">
                    <input type="password" maxlength="30" class="form-control" name="senha" value="<?php echo $c_senha; ?>">
                </div>
            </div>
            <br>
            <nav class="navbar ">
                <div class="container-fluid">
                    <br>
                    <button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-circle-arrow-right'></span> Continuar</button>
                    <a class='btn btn-danger' href='/fundeb/index.php'><span class='glyphicon glyphicon-remove'></span> Cancelar</a>

                </div>
            </nav>
    </div>

    </div>
    </form>
    </div>
</body>

</html>