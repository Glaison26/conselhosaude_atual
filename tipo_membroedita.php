<?php
$i_id = $_GET["id"];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //

    $op1 = '';
    $op2 = '';



    // conexão com o banco de dados
    $servername = 'localhost';
    $username = 'root';
    $password =  '';
    $database = 'fundeb';
    // criando a conexão com banco de dados
    $conection = new mysqli($servername, $username, $password, $database);
    // checo erro na conexão
    if ($conection->connect_error) {
        die("Erro na Conexão com o Banco de Dados!! " . $conection->connect_error);
    }
    // sql com registro encontrado
    $c_sql = 'SELECT *  FROM membros where id=' . $i_id;
    $result = $conection->query($c_sql);
    $registro = $result->fetch_assoc();
    if ($registro['tipo'] == 'Eleitor') {
        $op1 = "checked";
    } else {
        $op2 = "checked";
    }
    $c_nome = $registro['nome'];
}

/// pego opção selecionada
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    $_SESSION['c_tipo'] = $_POST['tipo'];
    header('location: /fundeb/segmentoedita.php?id=' . $i_id);
}

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
                <strong>Selecione se voçê é Candidato ou Eleitor e clique em continuar. </strong>
            </div>
        </div>
        <form method="post">
            <hr>
            <div class="row mb-2">
                <label class="col-sm-2 col-form-label">Nome cadastrado</label>
                <div class="col-sm-4">
                    <input type="text" maxlength="120" class="form-control" disabled name="nome" value="<?php echo $c_nome; ?>">
                </div>
            </div>
            <div>

                <p>
                <h5>Eu sou :</h5>
                </p>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo" id="tipoeleitor" Value="Eleitor" <?php echo $op1 ?>>
                    <label class="form-check-label" for="tipoeleitor">
                        Eleitor
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo" id="tipocandidato" value="Candidato" <?php echo $op2 ?>>
                    <label class="form-check-label" for="tipocandidato">
                        Candidato
                    </label>
                </div>
            </div>
            <br>
            <nav class="navbar ">
                <div class="container-fluid">
                    <br>
                    <button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-circle-arrow-right'></span> Continuar</button>
                    <a class='btn btn-danger' href='/fundeb/entracpf.php'><span class='glyphicon glyphicon-remove'></span> Cancelar</a>

                </div>
            </nav>
    </div>

    </div>
    </form>
    </div>
</body>

</html>