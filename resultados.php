<?php // controle de acesso ao formulário
//session_start();
//if (!isset($_SESSION['newsession'])) {
//    die('Acesso não autorizado!!!');
//}
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
$c_segmento = '0';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $c_segmento = $_POST['segmento'];
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PMS - Eleição Conselho Municipal de Saúde</title>
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

    <div class="panel panel-light" style="background-color: #e3f2fd;">
        <div class="panel-heading text-center">
            <h2>Resultados da Eleição por Segmento</h2>
        </div>
    </div>

    <br>
    <div class="container -my5">

        <div>
            <form method="post">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Segmento</label>

                    <div class="col-sm-6">
                        <select class="form-control form-control-lg" id="segmento" name="segmento">
                            <option <?= ($c_segmento == '1') ? 'selected' : '' ?> value="1">1. Cadastro para usuários do SUS </option>
                            <option <?= ($c_segmento == '2') ? 'selected' : '' ?> value="2">2. Cadastro para trabalhadores do SUS</option>
                            <option <?= ($c_segmento == '3') ? 'selected' : '' ?> value="3">3. Cadastro para Organizações não governamentais</option>

                        </select>
                    </div>
                </div>
                <hr>
                <?php $caminho = '/fundeb/graficos.php?id=' . $c_segmento; ?>
                <button type="submit" class="btn btn-primary "><span class='glyphicon glyphicon-plus'></span> Apurar</button>
                <a class="btn btn-info btn-sm" href=<?php echo $caminho; ?>><span class="glyphicon glyphicon-signal"></span> Gráfico</a>
                <a class="btn btn-secondary btn-sm" href="/fundeb/lista.php"><span class="glyphicon glyphicon-off"></span> Voltar</a>
            </form>
        </div>
        <hr>

    </div>
</body>

</html>