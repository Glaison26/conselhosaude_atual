<?php

include("../conexao.php");

function registrarVoto($conection, $id_eleitor, $id_candidato){
    
    $id_eleitor = intval($id_eleitor);
    $id_candidato = intval($id_candidato);

    $sql = "INSERT INTO votos (id_eleitor, id_candidato)
            VALUES ($id_eleitor, $id_candidato)";

    if (mysqli_query($conection, $sql)) {
        return true;
    }

    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_eleitor = $_POST['user_id'];
    $id_candidato = $_POST['candidato_id'];

    if (registrarVoto($conection, $id_eleitor, $id_candidato)) {
        echo "Voto registrado com sucesso!";
    } else {
        echo "Erro ao registrar o voto.";
    }
}
?>
