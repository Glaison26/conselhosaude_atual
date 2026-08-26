<?php

// Conexão com o banco
include("../conexao.php");

// Verifica se o ID foi enviado
if (!isset($_GET['id'])) {
    die("ID do usuário não informado.");
}

$user_id = intval($_GET['id']);

// Busca a unidade SUS do usuário
$sql = "SELECT SUS_UNIDADE FROM cadastro WHERE id = $user_id";

$resultado = mysqli_query($conection, $sql);

if (!$resultado) {
    die("Erro na consulta: " . mysqli_error($conection));
}

$reg_usuario = mysqli_fetch_assoc($resultado);

if (!$reg_usuario) {
    die("Usuário não encontrado.");
}

// Busca o nome do usuário
$sql = "SELECT SUS_NOME FROM cadastro WHERE id = $user_id";

$resultado = mysqli_query($conection, $sql);

if (!$resultado) {
    die("Erro ao buscar nome: " . mysqli_error($conection));
}

$nome_usuario = mysqli_fetch_assoc($resultado);

// Busca os candidatos da mesma unidade
$reg_candidato = mysqli_real_escape_string(
    $conection,
    $reg_usuario['SUS_UNIDADE']
);

$sql = "
    SELECT id, SUS_NOME, APRESENTACAO, FOTO
    FROM cadastro 
    WHERE SUS_UNIDADE = '$reg_candidato'
    AND CATEGORIA = 1
    AND CANDIDATO = 'S'
    ORDER BY SUS_NOME
";

$res = mysqli_query($conection, $sql);

if (!$res) {
    die("Erro ao buscar candidatos: " . mysqli_error($conection));
}

$candidatos = [];

while ($row = mysqli_fetch_assoc($res)) {
    $candidatos[] = $row;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <title>PMS - Eleição Conselho Municipal de Saúde</title>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body>

<div class="panel panel-primary">

    <div class="panel-heading text-center">

        <h4>Conselho Municipal de Saúde</h4>

        <h5>Eleição dos Membros do Conselho Municipal de Saúde</h5>

    </div>

</div>


<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-body">

                    <h3 class="card-title mb-4">

                        Olá <?= htmlspecialchars($nome_usuario['SUS_NOME']) ?>,
                        Selecione o Candidato

                    </h3>


                    <form action="processar_voto.php" method="POST">

                        <!-- Envia também o ID do usuário -->

                        <input 
                            type="hidden" 
                            name="user_id" 
                            value="<?= $user_id ?>"
                        >


                        <div class="mb-3">

                            <label for="candidato" class="form-label form-label-lg">

                                Candidato

                            </label>


                            <select
                                name="candidato_id"
                                id="candidato"
                                class="form-control"
                                required
                            >

                                <option value="" selected disabled>

                                    Selecione um candidato

                                </option>


                                <?php foreach ($candidatos as $candidato): ?>

                                    <option 
                                        value="<?= $candidato['id'] ?>"

                                        data-descricao="<?= htmlspecialchars(
                                            $candidato['APRESENTACAO'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"

                                        data-foto="../img/<?= htmlspecialchars(
                                            $candidato['FOTO'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                    >

                                        <?= htmlspecialchars(
                                            $candidato['SUS_NOME'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>


                            <!-- DADOS DO CANDIDATO -->

                            <div 
                                id="dadosCandidato"
                                style="display: none; margin-top: 20px;"
                            >

                                <div class="row">


                                    <!-- FOTO -->

                                    <div class="col-sm-5 text-center">

                                        <img 
                                            id="fotoCandidato"

                                            src=""

                                            alt="Foto do candidato"

                                            class="img-thumbnail"

                                            style="
                                                width: 220px;
                                                height: 220px;
                                                object-fit: cover;
                                            "
                                        >

                                    </div>


                                    <!-- APRESENTAÇÃO -->

                                    <div class="col-sm-7">

                                        <div class="panel panel-info">

                                            <div class="panel-heading">

                                                <strong>
                                                    Apresentação do candidato
                                                </strong>

                                            </div>


                                            <div 
                                                id="descricaoCandidato"

                                                class="panel-body"

                                                style="white-space: pre-line;"
                                            >
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <br>


                        <button 
                            type="submit" 
                            class="btn btn-primary btn-block"
                        >

                            Continuar

                        </button>


                        <button 
                            type="button" 
                            class="btn btn-danger btn-block" 
                            onclick="history.back()"
                        >

                            Voltar

                        </button>


                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

document.getElementById('candidato').addEventListener('change', function() {

    // Pega o candidato selecionado

    const candidatoSelecionado = this.options[this.selectedIndex];


    // Pega a apresentação

    const descricao = candidatoSelecionado.getAttribute('data-descricao');


    // Pega o caminho da foto

    const foto = candidatoSelecionado.getAttribute('data-foto');


    // Elementos da página

    const descricaoDiv = document.getElementById('descricaoCandidato');

    const fotoCandidato = document.getElementById('fotoCandidato');

    const dadosCandidato = document.getElementById('dadosCandidato');


    // =========================
    // APRESENTAÇÃO
    // =========================

    if (descricao && descricao.trim() !== '') {

        descricaoDiv.textContent = descricao;

    } else {

        descricaoDiv.textContent =
            'Este candidato não possui apresentação cadastrada.';

    }


    // =========================
    // FOTO
    // =========================

    if (foto && foto.trim() !== '') {

        fotoCandidato.src = foto;

        fotoCandidato.style.display = 'inline-block';

    } else {

        fotoCandidato.style.display = 'none';

    }

    dadosCandidato.style.display = 'block';

});

</script>


</body>

</html>