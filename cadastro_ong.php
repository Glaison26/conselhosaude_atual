<?php
session_start();

$c_nome_org = "";
$c_apresentacao = "";
$c_nome = "";
$d_datanasc = "";
$d_datafundacao = "";
$c_rg = "";
$c_endereco_org = "";
$c_endereco = "";
$c_escolaridade = "";
$c_email = "";
$c_email_org = "";
$c_telefone = "";
$c_telefone_org = "";
$c_cargo = "";
$c_cnpj_org = $_SESSION['cpf'];
$c_cpf = "";
if ($_SESSION['c_tipo'] == "Eleitor") {
    $c_esconde = "hidden";
} else {
    $c_esconde = "";
}
$c_tipocadastro = "";
$c_foto = "";
$c_nomefoto = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
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

            $c_nome_org = trim($_POST['nomeong']);
            $c_nome = trim($_POST['nomerepresentante']);

            $d_datanasc = $_POST['datanasc'];
            //$d_datanasc = $d_datanasc->format('Y-m-d');
            $d_datanasc = date("Y-m-d", strtotime(str_replace('/', '-', $d_datanasc)));

            $d_datafundacao = new DateTime($_POST['datafundacao']);
            $d_datafundacao = $d_datafundacao->format('Y-m-d');
            $c_rg = $_POST['rg'];
            $c_endereco_org = $_POST['enderecoong'];
            $c_endereco = $_POST['enderecorepresentante'];
            $c_email = $_POST['email'];
            $c_email_org = $_POST['email'];
            $c_telefone = $_POST['telefonerepre'];
            $c_telefone_org = $_POST['telefone'];
            $c_cargo = $_POST['cargo'];
            $c_cnpj_org = $_POST['cnpj'];
            $c_cpf = $_POST['cpf'];
            $c_escolaridade = $_POST['escolaridade'];
            $c_apresentacao = $_POST['apresentacao'];
            $c_cargo = $_POST['cargo'];
            $c_categoria = "3";
            $c_nomefoto = "";
            if ($_SESSION['c_tipo'] == "Eleitor") {
                $c_tipocadastro = "N";
            } else {
                $c_tipocadastro = "S";
            }
           // verificos se todos os campos foram preenchidos
            if (empty($c_nome_org)) {
                $c_erro = "Campo Nome da Organização deve ser preenchido!!";
                break;
            }
           
            if (empty($c_endereco_org)) {
                $c_erro = "Campo Endereço da Organização deve ser preenchido!!";
                break;
            }
             if (empty($c_telefone_org)) {
                $c_erro = "Campo Telefone da Organização deve ser preenchido!!";
                break;
            }
            if (empty($c_endereco)) {
                $c_erro = "Campo Endereço do Representante deve ser preenchido!!";
                break;
            }
            if (empty($c_email)) {
                $c_erro = "Campo E-mail do Representante deve ser preenchido!!";
                break;
            }
            if (empty($c_email_org)) {
                $c_erro = "Campo E-mail da Organização deve ser preenchido!!";
                break;
            }
            if (empty($c_telefone)) {
                $c_erro = "Campo Telefone do Representante deve ser preenchido!!";
                break;
            }
           
            if (empty($c_cargo)) {
                $c_erro = "Campo Cargo do Representante deve ser preenchido!!";
                break;
            }
            if (empty($c_cnpj_org)) {
                $c_erro = "Campo CNPJ da Organização deve ser preenchido!!";
                break;
            }
            if (empty($c_cpf)) {
                $c_erro = "Campo CPF do Representante deve ser preenchido!!";
                break;
            }
            if (empty($c_rg)) {
                $c_erro = "Campo RG do Representante deve ser preenchido!!";
                break;
            }
            if (empty($d_datanasc)) {
                $c_erro = "Campo Data de Nascimento do Representante deve ser preenchido!!";
                break;
            }
            if (empty($d_datafundacao)) {
                $c_erro = "Campo Data de Fundação da Organização deve ser preenchido!!";
                break;
            }
             if (empty($c_nome)) {
                $c_erro = "Campo Nome do Representante deve ser preenchido!!";
                break;
            }
            if (empty($c_escolaridade)) {
                $c_erro = "Campo Escolaridade do Representante deve ser preenchido!!";
                break;
            }
            if (empty($c_categoria)) {
                $c_erro = "Campo Categoria deve ser preenchido!!";
                break;
            }
            if (empty($c_tipocadastro)) {
                $c_erro = "Campo Tipo de Cadastro deve ser preenchido!!";
                break;
            }
                      
            if (empty($c_apresentacao) && ($_SESSION['c_tipo'] == "Candidato")) {
                $c_erro = "Campo apresentação deve ser preenchido!!" . $c_apresentacao . '-' . $_SESSION['c_tipo'];
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
            $c_sql = 'SELECT *  FROM cadastro where org_cnpj=' . $_SESSION['cpf'];
            $result = $conection->query($c_sql);
            $registro2 = $result->fetch_assoc();
            // Consistencias do formulário
            // faço a inclusão da tabela com sql
            // inclusão para eleitores
            if ($_SESSION['c_tipo'] == "Eleitor") {
                $c_sql = "Insert into cadastro (categoria,candidato,ORG_NOMEORG, ORG_ENDERORG, ORG_TELEFONE, ORG_EMAIL
                ,ORG_CNPJ, ORG_FUNDACAO, ORG_NOMEREPRESENTANTE, ORG_ENDERREPRE, ORG_FONEREPRE, ORG_EMAILREPRE,
                ORG_ESCOLARIDADEREPRE, ORG_RGREPRE, ORG_CPFREPRE, ORG_DATANASCREPRE, ORG_CARGOREPRE)" .
                    "Value ('$c_categoria', '$c_tipocadastro', '$c_nome_org', '$c_endereco_org', '$c_telefone_org', '$c_email_org',
                '$c_cnpj_org', '$d_datafundacao','$c_nome', '$c_endereco', '$c_telefone', '$c_email', '$c_escolaridade',
                '$c_rg', '$c_cpf', '$d_datanasc', '$c_cargo')";
            } else {
                $c_foto = $_SESSION['c_nomefoto'];

                $c_sql = "Insert into cadastro (categoria,candidato,ORG_NOMEORG, ORG_ENDERORG, ORG_TELEFONE, ORG_EMAIL
                ,ORG_CNPJ, ORG_FUNDACAO, ORG_NOMEREPRESENTANTE, ORG_ENDERREPRE, ORG_FONEREPRE, ORG_EMAILREPRE,
                ORG_ESCOLARIDADEREPRE, ORG_RGREPRE, ORG_CPFREPRE, ORG_DATANASCREPRE, ORG_CARGOREPRE, apresentacao, foto)" .
                    "Value ('$c_categoria', '$c_tipocadastro', '$c_nome_org', '$c_endereco_org', '$c_telefone_org', '$c_email_org',
                '$c_cnpj_org', '$d_datafundacao','$c_nome', '$c_endereco', '$c_telefone', '$c_email', '$c_escolaridade',
                '$c_rg', '$c_cpf', '$d_datanasc', '$c_cargo', '$c_apresentacao', '$c_foto')";
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
            $("#datanasc").mask("99/99/9999");
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


        <div class="container -my5">
            <div class="row mb-3" class="container">
                <div class="alert alert-success">
                    <strong>Entre com os seus dados e clique em enviar dados no final do formulário para finalizar </strong>

                </div>
            </div>


            <?php
            if (!empty($c_erro)) {
                echo "
            <div class='alert alert-warning' role='alert'>
                <h5>$c_erro</h5>
            </div>
                ";
            }
            ?>
        </div>


        <form method="post" enctype="multipart/form-data">
            <hr>
            <div class="row mb-3">
                <div class="col-sm-6 col-form-label">

                    <div class="row mb-3" name="divapresentacao" <?php echo $c_esconde ?>>
                        <label>Arquivo de foto: </label>
                        <input type="file" name="arquivo" accept="image/*"><br><br>
                        <button type="submit" name="btnfoto" id="btnfoto" class="btn btn-primary"><span class='glyphicon glyphicon-open-file'></span> Enviar Foto</button>
                        <h5>Foto do Representante da ONG Candidata</h5>
                        <div class="panel default class" class="row col-xs-12 col-sm-20 col-md-12 col-lg-20" align="center">
                            <img class="rounded mx-auto d-block" class="img-responsive" src="\conselhosaude\img\<?php echo $c_nomefoto; ?>" class="img-fluid" style="height :150px" style="width:200px">
                        </div>

                        <label class="col-sm-12 col-form-label">
                            Breve apresentação da ONG Candidata</label>
                        <div class="col-sm-16">
                            <textarea class="form-control" id="apresentacao" name="apresentacao" rows="10"><?php echo $c_apresentacao; ?></textarea>
                        </div>

                        <br>
                    </div>
                    <br>
                    <div class="row mb-3">
                        <br>
                        <p><strong>Dados da Organização não Governamental</strong>
                        <p>
                            <hr>
                    </div>
                    <div class="row mb-12">
                        <label class="col-sm-12 col-form-label">Nome da Organização</label>
                        <div class="col-sm-12">
                            <input type="text" maxlength="120" class="form-control" name="nomeong" value="<?php echo $c_nome_org; ?>">
                        </div>
                    </div>
                    <br>
                    <div class=" row mb-3">
                        <label class="col-sm-12 col-form-label">Endereço</label>
                        <div class="col-sm-12">
                            <input type="text" maxlength="120" class="form-control" name="enderecoong" value="<?php echo $c_endereco_org; ?>">
                        </div>
                    </div>

                    <br>
                    <div class=" row mb-3">
                        <label class="col-sm-12 col-form-label">Telefone</label>
                        <div class="col-sm-5">
                            <input type="text" maxlength="20" class="form-control" name="telefone" value="<?php echo $c_telefone_org; ?>">
                        </div>
                    </div>
                    <br>
                    <div class=" row mb-3">
                        <label class="col-sm-12 col-form-label">E-mail</label>
                        <div class="col-sm-12">
                            <input type="text" maxlength="150" class="form-control" name="email" value="<?php echo $c_email_org; ?>">
                        </div>
                    </div>
                    <br>
                    <div class=" row mb-3">
                        <label class="col-sm-12 col-form-label">CNPJ</label>
                        <div class="col-sm-5">
                            <input type="text" placeholder="apenas números" maxlength="18" class="form-control" name="cnpj" value="<?php echo $c_cnpj_org; ?>">
                        </div>
                    </div>
                    <br>
                    <div class=" row mb-3">
                        <label class="col-sm-12 col-form-label">Data da Fundação</label>
                        <div class="col-sm-5">
                            <input type="date" maxlength="10" class="form-control" name="datafundacao" id="datafundacao" value="<?php echo $d_datafundacao; ?>">
                        </div>
                    </div>
                    <br>
                    <div class="row mb-3">
                        <br>
                        <p><strong>Dados do Representante</strong>
                        <p>
                            <hr>
                    </div>
                    <div class="row mb-12">
                        <label class="col-sm-12 col-form-label">Nome do Representante</label>
                        <div class="col-sm-12">
                            <input type="text" maxlength="120" class="form-control" name="nomerepresentante" value="<?php echo $c_nome; ?>">
                        </div>
                    </div>
                    <br>
                    <div class=" row mb-3">
                        <label class="col-sm-12 col-form-label">Endereço</label>
                        <div class="col-sm-12">
                            <input type="text" maxlength="120" class="form-control" name="enderecorepresentante" value="<?php echo $c_endereco; ?>">
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
                        <label class="col-sm-12 col-form-label">Data de Nascimento</label>
                        <div class="col-sm-5">
                            <input type="date" maxlength="10" class="form-control" name="datanasc" id="datanasc" value="<?php echo $d_datanasc; ?>">
                        </div>
                    </div>
                    <br>
                    <div class=" row mb-3">
                        <label class="col-sm-12 col-form-label">Cargo ocupado na Organização</label>
                        <div class="col-sm-12">
                            <input type="text" maxlength="80" class="form-control" name="cargo" value="<?php echo $c_cargo; ?>">
                        </div>
                    </div>
                    <br>
                    <div class=" row mb-3">
                        <label class="col-sm-12 col-form-label">Telefone</label>
                        <div class="col-sm-5">
                            <input type="text" maxlength="20" class="form-control" name="telefonerepre" value="<?php echo $c_telefone_org; ?>">
                        </div>
                    </div>
                    <br>
                    <div class=" row mb-3">
                        <label class="col-sm-12 col-form-label">E-mail do representante</label>
                        <div class="col-sm-12">
                            <input type="text" maxlength="150" class="form-control" name="emailrepre" value="<?php echo $c_email; ?>">
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