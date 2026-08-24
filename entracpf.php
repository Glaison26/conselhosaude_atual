<?php

$dt_local = DateTime::createFromFormat('d-m-Y', date('d-m-Y'));
$dt_inicio = DateTime::createFromFormat('d-m-Y', '06-03-2023');
$dt_fim = DateTime::createFromFormat('d-m-Y', '12-03-2023');


//if ($dt_local < $dt_inicio) {
//    $c_prazo = 'Inscrições somente serão permitidas no período do dia 06 a 12 de março de 2023!!!';
//    header('location: /fundeb/prazo.php?id=' . $c_prazo);
//}

//if ($dt_local > $dt_fim) {
//    $c_prazo = 'Prazo de Inscrição Encerrado!!!';
//    header('location: /fundeb/prazo.php?id=' . $c_prazo);
//}
session_start();


include_once "lib_gop.php";

$c_erro = "";
$c_cpf = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
} else {
    do {
        if (empty($_POST['entracpf'])) {  // checo cpf em branco
            if (($_SESSION['c_segmento'] == "1") || (($_SESSION['c_segmento'] == "2"))) {
                $c_erro = "Campo de CPF deve ser preenchido favor verificar!!";
            } else {
                $c_erro = "Campo de CNPJ deve ser preenchido favor verificar!!";
            }
            break;
        }
        // checo cpf OU CNPJ
        if (($_SESSION['c_segmento'] == "1") || (($_SESSION['c_segmento'] == "2"))) {  // Checo CPF
            if (!validaCPF($_POST['entracpf'])) {
                $c_erro = 'CPF informado não e válido favor verificar!!';
                break;
            }
        } else {  // checo CNPJ
            if (!valida_cnpj($_POST['entracpf'])) {
                $c_erro = 'CNPJ informado não e válido favor verificar!!';
                break;
            }
        }
        $_SESSION['cpf'] = $_POST['entracpf']; // variavel de sessão com cpf OU CNPJ
        // conexão com o banco de dados
        $servername = 'localhost';
        $username = 'root';
        $password =  '';
        $database = 'eleicaosaude';
        // criando a conexão com banco de dados
        $conection = new mysqli($servername, $username, $password, $database);
        // checo erro na conexão
        if ($conection->connect_error) {
            die("Erro na Conexão com o Banco de Dados!! " . $conection->connect_error);
        }
        // sql para verificar se cpf ja existe
        // para usuário do sus
        if ($_SESSION['c_segmento'] == "1") {
            $c_sql = 'SELECT *  FROM cadastro  where sus_cpf=' . $_POST['entracpf'];
        }
        if ($_SESSION['c_segmento'] == "2") {
            $c_sql = 'SELECT *  FROM cadastro  where trabsus_cpf=' . $_POST['entracpf'];
        }
        if ($_SESSION['c_segmento'] == "3") {
            $c_sql = 'SELECT *  FROM cadastro  where org_cnpj=' . $_POST['entracpf'];
        }
        $result = $conection->query($c_sql);
        $registro = $result->fetch_assoc();

        if ((!$registro) && ($_SESSION['c_segmento'] == 1)) { // chama tipo de cadastro para registro novo de eleitor/candidato do sus
            header('location: /conselhosaude/cadastro_sus_eleitor.php');
        }
        if ((!$registro) && ($_SESSION['c_segmento'] == 2)) { // chama tipo de cadastro para registro novo de eleitor/candidato do trabalhador sus
            header('location: /conselhosaude/cadastro_trabsus_eleitor.php');
        }
        if ((!$registro) && ($_SESSION['c_segmento'] == 3)) { // chama tipo de cadastro para registro novo de eleitor/candidato do ong
            header('location: /conselhosaude/cadastro_ong.php');
        }
        if ($registro) { // chama tipo de cadastro para registro em edição
            //header('location: /conselhosaude/tipo_membroedita.php?id=' . $registro['id']); // passo id achada como parametro
            if (($_SESSION['c_segmento'] == "1") || (($_SESSION['c_segmento'] == "2"))) {  // menssagem com cpf
                $c_erro = 'CPF informado já se encontra cadastrado!!';
                break;
            } else {
                $c_erro = 'CNPJ informado já se encontra cadastrado!!';
                break;
            }
        }
    } while (false);
}

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
                        <?php
                        if (($_SESSION['c_segmento'] == "1") || (($_SESSION['c_segmento'] == "2"))) {
                            echo "<strong>Digite o CPF para Cadastro dos seus dados. </strong>";
                        } else {
                            echo "<strong>Digite o CNPJ para Cadastro dos dados da Organização. </strong>";
                        }
                        ?>
                    </div>
                </div>
                <br>
                <?php
                if (($_SESSION['c_segmento'] == "1") || (($_SESSION['c_segmento'] == "2"))) {
                    echo '<label class="col-sm-2 col-form-label">Informe seu CPF</label>' .
                        '<div class="col-sm-2">' .
                        '<input type="text" required maxlength="11" placeholder="apenas números" class="form-control" name="entracpf"' . '>' .
                        '</div>';
                } else {
                    echo '<label class="col-sm-2 col-form-label">Informe o CNPJ</label>' .
                        '<div class="col-sm-2">' .
                        '<input type="text" required maxlength="18" placeholder="apenas números" class="form-control" name="entracpf"' . '>' .
                        '</div>';
                }
                ?>
            </div>
            <br>
            <nav class="navbar">
                <div class="container-fluid">
                    <br>
                    <button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-circle-arrow-right'></span> Continuar</button>
                    <a class='btn btn-danger' href='/conselhosaude/index.php'><span class='glyphicon glyphicon-remove'></span> Cancelar</a>

                </div>
            </nav>
        </form>
    </div>
</body>

</html>