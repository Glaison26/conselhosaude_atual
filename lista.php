<?php // controle de acesso ao formulário
//session_start();
//if (!isset($_SESSION['newsession'])) {
//    die('Acesso não autorizado!!!');
//}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["btnlista"])) {
        if (($_POST['segmento']) == "1") {
            header('location: /conselhosaude/lista1.php');
        }
        if (($_POST['segmento']) == "2") {
            header('location: /conselhosaude/lista2.php');
        }
        if (($_POST['segmento']) == "3") {
            header('location: /conselhosaude/lista3.php');
        }
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PMS - Eleição Fundeb </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link href="https://nightly.datatables.net/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <script scr="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script scr="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script scr="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://nightly.datatables.net/js/jquery.dataTables.js"></script>

    <script language="Javascript">
        function confirmacao(id) {
            var resposta = confirm("Deseja remover esse registro?");
            if (resposta == true) {
                window.location.href = "/fundeb/lista_excluir.php?id=" + id;
            }
        }
    </script>

    <script language="Javascript">
        function mensagem(msg) {
            alert(msg);
        }
    </script>



    <div class="panel panel-light" style="background-color: #e3f2fd;">
        <div class="panel-heading text-center">
            <h2>Lista de Candidatos e Eleitores</h2>
        </div>
    </div>
    <br>
    <form method="post">
        <div class="container">
            <div class="alert alert-success">
                <strong>Veja a lista de Eleitores / Candidatos ou veja os resultados da eleição </strong>
            </div>
            <div class="row mb-3">
                <div class="col-sm-6 col-form-label">
                    <p>
                    <h5>Qual o tipo de Cadastro?</h5>
                    </p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="segmento" id="seg1" Value="1" checked>
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
            <br>

        </div>
        <div class="container -my5">
            <button name="btnlista" type="submit" id="btnlista" class="btn btn-primary"><span class='glyphicon glyphicon-th-list'></span> Cadastro</button>
            <a class="btn btn-success btn-sm" href="/fundeb/xxxxxx.php"><span class="glyphicon glyphicon-plus"></span> Resultados</a>
            <a class="btn btn-secondary btn-sm" href="/conselhosaude/index.php"><span class="glyphicon glyphicon-off"></span> Voltar</a>
            <hr>
        </div>
    </form>
</body>

</html>