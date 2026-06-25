<?php
session_start();
$c_escolha = @$_POST['unidade'];

if ($_SESSION['c_tipo'] == "Eleitor") {
    $c_esconde = "hidden";
} else {
    $c_esconde = "";
}
$c_nome = "";
$c_datanasc = "";
$c_rg = "";
$c_cartaosus = "";
$c_endereco = "";
$c_bairro = "";
$c_naturalidade = "";
$c_unidade = "";
$c_escolaridade = "";
$c_estabelecimento = "";
$c_vinculo = "";
$c_endertrab = "";
$c_cargo = "";
$c_apresentacao = "";
$c_cpf = $_SESSION['cpf'];
$c_nomefoto = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_SESSION['c_tipo'] == "Eleitor") {
        $c_esconde = "hidden";
    } else {
        $c_esconde = "";
    }
    $c_nome = "";
    $c_datanasc = "";
    $c_rg = "";
    $c_cartaosus = "";
    $c_endereco = "";
    $c_bairro = "";
    $c_naturalidade = "";
    $c_unidade = "";
    $c_escolaridade = "";
    $c_estabelecimento = "";
    $c_vinculo = "";
    $c_endertrab = "";
    $c_cargo = "";
    $c_apresentacao = "";
    $c_cpf = $_SESSION['cpf'];
    $c_nomefoto = "";
} else {
    //
    do {
        if (isset($_POST["btnfoto"])) {
            $dir = "img/";
            $arquivo = $_FILES['arquivo'];
            $_SESSION['c_nomefoto'] = $_FILES['arquivo']['name'];

            $c_nomefoto = $arquivo["name"];
            move_uploaded_file($arquivo["tmp_name"], "$dir/" . $arquivo["name"]);
        }

        // posts para gravação das informações
        if (isset($_POST["btngrava"])) {
            $c_endereco = $_POST['endereco'];
            $c_nome = trim($_POST['nome']);
            $d_datanasc = $_POST['datanasc'];
            $d_datanasc = date("Y-m-d", strtotime(str_replace('/', '-', $d_datanasc)));
            $c_rg = $_POST['rg'];
            $c_cpf = $_POST['cpf'];
            $c_bairro = $_POST['bairro'];
            $c_estabelecimento = $_POST['estabelecimento'];
            $c_vinculo = $_POST['vinculo'];
            $c_endertrab = $_POST['endertrab'];
            $c_cargo = $_POST['cargo'];
            $c_categoria = $_SESSION['c_segmento'];
            $c_escolaridade = $_POST['escolaridade'];
            $c_apresentacao = $_POST['apresentacao'];
            if ($_SESSION['c_tipo'] == "Eleitor") {
                $c_tipocadastro = "N";
            } else {
                $c_tipocadastro = "S";
            }

            // consistencia da digitação
            if (
                empty($c_nome) || (empty($c_rg)) || (empty($c_endereco)) || (empty($c_bairro))
            ) {

                $c_erro = "Campos nome, endereço, bairro e RG devem ser preenchidos!!";
                break;
            }
            if (empty($c_estabelecimento) || (empty($c_vinculo)) || (empty($c_endertrab)) || (empty($c_cargo))) {

                $c_erro = "Campos estabelecimento, endereço estabelecimento, vinculo e cargo devem ser preenchidos!!";
                break;
            }

            if (empty($c_apresentacao) && ($_SESSION['c_tipo'] == "Candidato")) {
                $c_erro = "Campo apresentação deve ser preenchido!!";
                break;
            }

            if (empty($_SESSION['c_nomefoto']) && ($_SESSION['c_tipo'] == "Candidato")) {
                $c_erro = "Foto do Candidato dever ser selecionada e enviada!!";
                break;
            }
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
            // verifico novamente se já existe o cpf
            $c_sql = 'SELECT *  FROM cadastro where trabsus_cpf=' . $_SESSION['cpf'];
            $result = $conection->query($c_sql);
            $registro2 = $result->fetch_assoc();
            // Consistencias do formulário

            // faço a inclusão da tabela com sql
            if ($_SESSION['c_tipo'] == "Eleitor") {
                $c_sql = "Insert into cadastro (categoria,candidato,TRABSUS_NOME,trabsus_cpf,TRABSUS_ESCOLARIDADE,TRABSUS_RG,TRABSUS_DATANASC,TRABSUS_ENDER
                     ,TRABSUS_BAIRRO, TRASUS_ESTABELECIMENTO, TRABSUS_ENDERLOCALTRAB, TRAB_SUS_VINCULO, TRASUS_CARGO)" .
                    "Value ('$c_categoria', '$c_tipocadastro', '$c_nome', '$c_cpf', '$c_escolaridade', '$c_rg','$d_datanasc' 
                     , '$c_endereco','$c_bairro', '$c_estabelecimento', '$c_endertrab', '$c_vinculo', '$c_cargo')";
            } else {
                $c_foto = $_SESSION['c_nomefoto'];
                $c_sql = "Insert into cadastro (categoria,candidato,TRABSUS_NOME,trabsus_cpf,TRABSUS_ESCOLARIDADE,TRABSUS_RG,TRABSUS_DATANASC,TRABSUS_ENDER
                     ,TRABSUS_BAIRRO, TRASUS_ESTABELECIMENTO, TRABSUS_ENDERLOCALTRAB, TRAB_SUS_VINCULO, TRASUS_CARGO, apresentacao, foto )" .
                    "Value ('$c_categoria', '$c_tipocadastro', '$c_nome', '$c_cpf', '$c_escolaridade', '$c_rg','$d_datanasc' 
                     , '$c_endereco','$c_bairro', '$c_estabelecimento', '$c_endertrab', '$c_vinculo', '$c_cargo','$c_apresentacao', '$c_foto')";
            }
            if (!$registro2) {
                $result = $conection->query($c_sql);
                // verifico se a query foi correto
                if (!$result) {
                    die("Erro ao Executar Sql!!" . $conection->connect_error);
                }
            }
            if ($registro2) {
                header('location: /conselhosaude/erro.php');
            } else {
                header('location: /conselhosaude/sucesso.php');
            }
        }
    } while (false);
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
            $("#datanasc").mask("99/99/9999")
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

        <div class="container -my5">
            <div class="row mb-3" class="container">
                <div class="alert alert-success">
                    <strong>Entre com os seus dados e clique em enviar dados no final do formulário para finalizar </strong>
                </div>
            </div>
        </div>
        <form method="post" enctype="multipart/form-data">
            <hr>
            <div class="row mb-6">
                <div class="col-sm-6 col-form-label">
                    <div name="divapresentacao" <?php echo $c_esconde ?>>
                        <label>Arquivo de foto: </label>
                        <input type="file" name="arquivo" accept="image/*"><br><br>
                        <button type="submit" name="btnfoto" id="btnfoto" class="btn btn-primary"><span class='glyphicon glyphicon-open-file'></span> Enviar Foto</button>
                        <h5>Foto do Candidato</h5>
                        <div class="panel default class" class="row col-xs-12 col-sm-20 col-md-12 col-lg-40" align="center">
                            <img class="rounded mx-auto d-block" class="img-responsive" src="\conselhosaude\img\<?php echo $c_nomefoto; ?>" class="img-fluid" style="height :150px" style="width:200px">
                        </div>

                        <label class="col-sm-12 col-form-label">
                            Breve apresentação do Candidato</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" id="apresentacao" name="apresentacao" rows="10"><?php echo $c_apresentacao; ?></textarea>
                        </div>

                        <br>
                    </div>

                    <div class="col-sm-12 col-form-label">
                        <div class="row mb-3">
                            <br>
                            <label class="col-sm-12 col-form-label">Nome Completo</label>
                            <div class="col-sm-12">
                                <input type="text" maxlength="120" class="form-control" name="nome" value="<?php echo $c_nome; ?>">
                            </div>
                        </div>
                        <br>
                        <div class=" row mb-3">
                            <label class="col-sm-12 col-form-label">Data Nascimento</label>
                            <div class="col-sm-5">
                                <input type="text" maxlength="10" class="form-control" name="datanasc" id="datanasc" value="<?php echo $c_datanasc; ?>" />
                            </div>
                        </div>
                        <br>
                        <div class=" row mb-3">
                            <label class="col-sm-12 col-form-label">Número do RG</label>
                            <div class="col-sm-5">
                                <input type="text" maxlength="20" class="form-control" name="rg" value="<?php echo $c_rg; ?>">
                            </div>
                        </div>
                        <br>
                        <div class=" row mb-3">
                            <label class="col-sm-12 col-form-label">CPF</label>
                            <div class="col-sm-5">
                                <input type="text" placeholder="apenas números" maxlength="11" class="form-control" name="cpf" value="<?php echo $c_cpf; ?>">
                            </div>
                        </div>
                        <br>
                        <div class=" row mb-3">
                            <label class="col-sm-12 col-form-label">Endereço</label>
                            <div class="col-sm-12">
                                <input type="text" maxlength="120" class="form-control" name="endereco" value="<?php echo $c_endereco; ?>">
                            </div>
                        </div>
                        <br>
                        <div class=" row mb-3">
                            <label class="col-sm-12 col-form-label">Bairro</label>
                            <div class="col-sm-12">
                                <input type="text" maxlength="100" class="form-control" name="bairro" value="<?php echo $c_bairro; ?>">
                            </div>
                        </div>
                        <br>
                        <div class=" row mb-3">
                            <label class="col-sm-12 col-form-label">Estabelecimento de saúde Pública ou Conveniado ao SUS em que trabalha</label>
                            <div class="col-sm-12">
                                <input type="text" maxlength="120" class="form-control" name="estabelecimento" value="<?php echo $c_estabelecimento; ?>">
                            </div>
                        </div>
                        <br>
                        <div class=" row mb-3">
                            <label class="col-sm-12 col-form-label">Endereço do local de trabalho</label>
                            <div class="col-sm-12">
                                <input type="text" maxlength="120" class="form-control" name="endertrab" value="<?php echo $c_endertrab; ?>">
                            </div>
                        </div>
                        <br>
                        <div class=" row mb-3">
                            <label class="col-sm-12 col-form-label">Vinculo Empregaticio</label>
                            <div class="col-sm-12">
                                <input type="text" maxlength="100" class="form-control" name="vinculo" value="<?php echo $c_vinculo; ?>">
                            </div>
                        </div>
                        <br>
                        <div class=" row mb-3">
                            <label class="col-sm-12 col-form-label">Cargo exercido na Atualidade</label>
                            <div class="col-sm-12">
                                <input type="text" maxlength="100" class="form-control" name="cargo" value="<?php echo $c_cargo; ?>">
                            </div>
                        </div>
                        <br>
                        <div class=" row mb-3">
                            <label class="col-sm-12 col-form-label">Escolaridade</label>
                            <div class="col-sm-6">
                                <select class="form-control form-control-lg" id="escolaridade" name="escolaridade">
                                    <option>Curso Primário</option>
                                    <option>Primeiro Grau Incompleto</option>
                                    <option>Primeiro Grau Completo</option>
                                    <option>Segundo Grau Incompleto</option>
                                    <option>Segundo Grau Completo</option>
                                    <option>Superior Incompleto</option>
                                    <option>Superior Completo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
            <br>
            <div class="row mb-3 ">
                <nav class="navbar">
                    <div class="container-fluid">
                        <button type="submit" name="btngrava" id="btngrava" class="btn btn-primary "><span class='glyphicon glyphicon-floppy-saved'></span> Enviar Dados</button>
                        <a class='btn btn-danger ' href='/conselhosaude/index.php'><span class='glyphicon glyphicon-remove'></span> Cancelar</a>
                    </div>
                </nav>
            </div>
            <br>
        </form>
    </div>


</body>

</html>