<?php 
include_once "lib_gop.php";

$c_erro = "";
$c_cpf = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      
       
        $_SESSION['cpf'] = $_POST['entracpf']; // variavel de sessão com cpf
       
        // sql para verificar se cpf ja existe
        $c_sql = 'SELECT *  FROM membros where cpf=' . $_POST['entracpf'];
        $result = $conection->query($c_sql);
        $registro = $result->fetch_assoc();
        // se não existrir registro de cpf no banco de dados não permite votar e retorna mensagem de erro
        if (!$registro) {
            $c_erro = 'CPF informado não consta no cadastro de eleitores do Fundeb favor verificar!!';
        } else {
            // verifico se ja votou
            $c_sql = 'SELECT * FROM votacao where id_eleitor =' . $registro['id'];
            $result = $conection->query($c_sql);
            $registrovoto = $result->fetch_assoc();
            if ($registrovoto) {
                $c_erro = 'Eleitor do CPF digitado já votou. Apenas um voto é permitido !!';
            } else {
                // passou pelos teste chamo arquivo para votar com os dados
                header('location: /fundeb/votacao.php?id=' . $registro['id']); // passo id achada como parametro
            }
        }
        // verifico se ja votou
        // passou pelos teste chamo arquivo para votar com os dados
        header('location: /fundeb/votacao.php?id=' . $registro['id']); // passo id achada como parametro
}
?>