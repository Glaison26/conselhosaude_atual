<?php // controle de acesso ao formulário
//session_start();
//if (!isset($_SESSION['newsession'])) {
//    die('Acesso não autorizado!!!');
//}
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


    <script>
        $(document).ready(function() {
            $('.tablista').DataTable({
                // 
                "iDisplayLength": 7,
                "order": [1, 'asc'],
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [6]
                }, {
                    'aTargets': [0],
                    "visible": false
                }],
                "oLanguage": {
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sInfoFiltered": " - filtrado de _MAX_ registros",
                    "oPaginate": {
                        "spagingType": "full_number",
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLoadingRecords": "Carregando...",
                        "sProcessing": "Processando...",
                        "sZeroRecords": "Nenhum registro encontrado",
                        "sLast": "Último"
                    },
                    "sSearch": "Pesquisar",
                    "sLengthMenu": 'Mostrar <select>' +
                        '<option value="5">5</option>' +
                        '<option value="10">10</option>' +
                        '<option value="20">20</option>' +
                        '<option value="30">30</option>' +
                        '<option value="40">40</option>' +
                        '<option value="50">50</option>' +
                        '<option value="-1">Todos</option>' +
                        '</select> Registros'

                }

            });

        });
    </script>
    <div class="panel panel-light" style="background-color: #e3f2fd;">
        <div class="panel-heading text-center">
            <h2>Lista de Candidatos e Eleitores </h2>
            <h2>Trabalhadores do SUS</h2>
        </div>
    </div>

    <br>
    <div class="container -my5">
        <a class="btn btn-secondary btn-sm" href="/conselhosaude/lista.php"><span class="glyphicon glyphicon-off"></span> Voltar</a>

        <hr>
        <table class="table display table-hover  table-condensed tablista">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">RG</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Candidato</th>
                    <th scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php
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
                // faço a Leitura da tabela com sql
                $c_sql = "SELECT id, TRABSUS_NOME, TRABSUS_RG, TRABSUS_CPF, TRASUS_CARGO, candidato FROM cadastro where cadastro.categoria='2'";
                $result = $conection->query($c_sql);

                // verifico se a query foi correto
                if (!$result) {
                    die("Erro ao Executar Sql!!" . $conection->connect_error);
                }
                // pesquiso os registro do banco de dados na tabela 
                while ($c_linha = $result->fetch_assoc()) {
                    if ($c_linha['candidato'] == 'S') {
                        $c_tipocadastro = "SIM";
                    } else {
                        $c_tipocadastro = "NÃO";
                    }

                    echo "
                    <tr>
                    <td>$c_linha[id]</td>
                    <td>$c_linha[TRABSUS_NOME]</td>   
                    <td>$c_linha[TRASUS_CARGO]</td>
                    <td>$c_linha[TRABSUS_RG]</td>               
                    <td>$c_linha[TRABSUS_CPF]</td>
                    <td>$c_tipocadastro</td>
                    <td>
                          
                    <a class='btn btn-success btn-sm' title='Abrir detalahamento do item' href='/conselhosaude/detalhe2.php?id=$c_linha[id]'><span class='glyphicon glyphicon-zoom-in'></span></a>
                    
                    
                    </td>

                    </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>