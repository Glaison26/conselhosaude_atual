<?php
$servername = 'localhost';
$username = 'root';
$password =  '';
$database = 'eleicaosaude';
// criando a conexão com banco de dados// criando a conexão com banco de dados
$conection = new mysqli($servername, $username, $password, $database);
// checo erro na conexão
if ($conection->connect_error) {
    die("Erro na Conexão com o Banco de Dados!! " . $conection->connect_error);
}
$c_id = $_GET["id"];
if ($_SERVER['REQUEST_METHOD'] == 'GET') {  // metodo get para carregar dados no formulário
    if (!isset($_GET["id"])) {
        header('location: /pcas/lista1.php');
        exit;
    }
    // leitura do cliente através de sql usando id passada
    $c_sql = "select id, cadastro.SUS_NOME, cadastro.SUS_RG, cadastro.SUS_DATANASC, cadastro.SUS_CARTAOSUS,
    cadastro.SUS_CPF, cadastro.SUS_ENDER, cadastro.SUS_BAIRRO, cadastro.SUS_NATURALIDADE, cadastro.SUS_ESCOLARIDADE,
    cadastro.candidato, cadastro.foto, cadastro.apresentacao, cadastro.sus_unidade from cadastro where id=$c_id";
    $result = $conection->query($c_sql);
    $registro = $result->fetch_assoc();

    if (!$registro) {
        header('location: /conselhosaude/lista1.php');
        exit;
    }
    // achou registro
    if (($registro['candidato'] == 'N')) {
        $c_esconde = "hidden";
    } else {
        $c_esconde = "";
    }
    $c_foto = $registro['foto'];
    $c_apresentacao = $registro['apresentacao'];
    $c_unidade = $registro['sus_unidade'];
    $c_nome = $registro['SUS_NOME'];
    $c_datanasc = $registro['SUS_DATANASC'];
    $c_rg = $registro['SUS_RG'];
    $c_cartaosus = $registro['SUS_CARTAOSUS'];
    $c_cpf = $registro['SUS_CPF'];
    $c_endereco = $registro['SUS_ENDER'];
    $c_bairro = $registro['SUS_BAIRRO'];
    $c_naturalidade = $registro['SUS_NATURALIDADE'];
    $c_escolaridade = $registro['SUS_ESCOLARIDADE'];
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

    <script type="text/javascript">
        $(document).ready(function() {
            $("#telefone").mask("(99)9999-9999");
            $("#cep").mask("99.999-999");
        });
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
        <?php
        if (!empty($c_erro)) {
            echo "
            <div class='alert alert-warning' role='alert'>
                <h3>$c_erro</h3>
            </div>
                ";
        }
        ?>
        <form method="post" enctype="multipart/form-data">
            <hr>
            <div class="row mb-3">
                <div class="col-sm-6 col-form-label">

                    <div class="row mb-3" name="divapresentacao" <?php echo $c_esconde ?>>
                        <h5>Foto do Candidato</h5>
                        <div class="panel default class" class="row col-xs-12 col-sm-20 col-md-12 col-lg-20" align="center">
                            <img class="rounded mx-auto d-block" class="img-responsive" src="\conselhosaude\img\<?php echo $c_foto; ?>" class="img-fluid" style="height :150px" style="width:200px">
                        </div>

                        <label class="col-sm-12 col-form-label">
                            Breve apresentação do Candidato</label>
                        <div class="col-sm-16">
                            <textarea class="form-control" id="apresentacao" readonly name="apresentacao" rows="10"><?php echo $c_apresentacao; ?></textarea>
                        </div>

                        <br>
                    </div>
                    <br>
                    <div class=" row mb-3">
                        <label class="col-sm-12 col-form-label">Unidade básica de urgência</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" readonly name="unidade" value="<?php echo $c_unidade; ?>">
                        </div>
                    </div>

                    <br>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nome Completo</label>
                        <div class="col-sm-12">
                            <input type="text" maxlength="120" class="form-control" readonly name="nome" value="<?php echo $c_nome; ?>">
                        </div>
                    </div>
                    <br>
                    <div class=" row mb-3">
                        <label class="col-sm-12 col-form-label">Data Nascimento</label>
                        <div class="col-sm-5">
                            <input type="date" maxlength="10" class="form-control" name="datanasc" readonly id="datanasc" value="<?php echo $c_datanasc; ?>">
                        </div>
                    </div>
                    <br>
                    <div class=" row mb-3">
                        <label class="col-sm-12 col-form-label">Número do RG</label>
                        <div class="col-sm-5">
                            <input type="text" maxlength="20" class="form-control" name="rg" readonly value="<?php echo $c_rg; ?>">
                        </div>
                    </div>
                    <br>
                    <div class=" row mb-3">
                        <label class="col-sm-12 col-form-label">CPF</label>
                        <div class="col-sm-5">
                            <input type="text" placeholder="apenas números" maxlength="11" class="form-control" readonly name="cpf" value="<?php echo $c_cpf; ?>">
                        </div>
                    </div>
                    <br>
                    <div class=" row mb-3">
                        <label class="col-sm-12 col-form-label">No. Cartão SUS</label>
                        <div class="col-sm-5">
                            <input type="text" placeholder="apenas números" maxlength="15" class="form-control" readonly name="cartaosus" value="<?php echo $c_cartaosus; ?>">
                        </div>
                    </div>
                    <br>
                    <div class=" row mb-3">
                        <label class="col-sm-12 col-form-label">Endereço</label>
                        <div class="col-sm-12">
                            <input type="text" maxlength="120" class="form-control" name="endereco" readonly value="<?php echo $c_endereco; ?>">
                        </div>
                    </div>
                    <br>
                    <div class=" row mb-3">
                        <label class="col-sm-12 col-form-label">Bairro</label>
                        <div class="col-sm-12">
                            <input type="text" maxlength="100" class="form-control" name="bairro" readonly value="<?php echo $c_bairro; ?>">
                        </div>
                    </div>
                    <br>
                    <div class=" row mb-3">
                        <label class="col-sm-12 col-form-label">Naturalidade</label>
                        <div class="col-sm-12">
                            <input type="text" maxlength="50" class="form-control" name="naturalidade" readonly value="<?php echo $c_naturalidade; ?>">
                        </div>
                    </div>
                    <br>
                    <div class=" row mb-3">
                        <label class="col-sm-12 col-form-label">Escolaridade</label>
                        <div class="col-sm-6">
                            <input type="text" maxlength="50" class="form-control" name="escolaridade" readonly value="<?php echo $c_escolaridade; ?>">

                        </div>
                    </div>
                </div>
                <br>

            </div>
            <br>
            <div class="row mb-3 ">
                <nav class="navbar">
                    <div class="container-fluid">

                        <a class='btn btn-danger ' href='/conselhosaude/lista1.php'><span class='glyphicon glyphicon-log-out'></span> Voltar</a>
                    </div>
                </nav>
            </div>
            <br>
        </form>
    </div>


</body>

</html>