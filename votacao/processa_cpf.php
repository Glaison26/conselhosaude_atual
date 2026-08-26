<?php

include("../conexao.php");


$c_erro = "";
$c_cpf = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $_SESSION['cpf'] = $_POST['entracpf']; // variavel de sessão com cpf

    // sql para verificar se cpf ja existe
    $c_sql = 'SELECT id FROM cadastro where sus_cpf=' . $_POST['entracpf'] . ' or ' . ' trabsus_cpf=' . $_POST['entracpf'] .
        ' or ' . ' org_cnpj=' . $_POST['entracpf'];
    $result_cadastro = $conection->query($c_sql);
    $registro2 = $result_cadastro->fetch_assoc();
    //echo $registro;
    //die();
    $id_eleitor = $registro2['id'];
    // se não existrir registro de cpf no banco de dados não permite votar e retorna mensagem de erro
    if (!$registro2) {
        // exibo mensagem de erro dem javascript e retorno para tela de entrada de cpf
        $c_erro = 'CPF/CNPJ informado não existe no cadastro de eleitores. Favor verificar!!';
        $c_cpf = $_POST['entracpf'];
        // mensagem de erro para tela de entrada de cpf
        echo "<script>
                alert('$c_erro');
                window.location.href = 'cpf_votacao.php';
                </script>";
    } else {
        // verifico se ja votou
        $c_sql = 'SELECT * FROM votos where id_eleitor =' . $id_eleitor;
        $result = $conection->query($c_sql);
        $registrovoto = $result->fetch_assoc();
        if ($registrovoto) {
            $c_erro = 'CPF/CNPJ informado já realizou a votação. Não é permitido votar mais de uma vez!!';
            $c_cpf = $_POST['entracpf'];
            // mensagem de erro para tela de entrada de cpf
            echo "<script>
                alert('$c_erro');
               window.location.href = 'cpf_votacao.php';
                </script>";
        } else {
            // passou pelos teste chamo arquivo para votar com os dados
            //header('location: /conselhosaude/votacao/votacao.php?id=' . $id_eleitor); // passo id achada como parametro

            $sql = "SELECT categoria FROM cadastro WHERE id = $id_eleitor";
            $result = mysqli_query($conection, $sql);
            if (!$result) {
                die("Erro na consulta: " . mysqli_error($conection));
            }
            $cat_usuario = mysqli_fetch_assoc($result);


            if($cat_usuario['categoria'] == 1) {
                header('location: /conselhosaude/votacao/votacao_sus.php?id=' . $id_eleitor);
            } elseif($cat_usuario['categoria'] == 2) {
                header('location: /conselhosaude/votacao/votacao_trabsus.php?id=' . $id_eleitor);
            } elseif($cat_usuario['categoria'] == 3) {
                header('location: /conselhosaude/votacao/votacao_ong.php?id=' . $id_eleitor);
            } else {
                $c_erro = 'Categoria do usuário não reconhecida. Contate o administrador.';
                echo "<script>
                    alert('$c_erro');
                    window.location.href = 'cpf_votacao.php';
                    </script>";

            }


        }
    }
}
