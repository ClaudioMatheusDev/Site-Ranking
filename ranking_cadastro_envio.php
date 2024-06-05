<?php
include('conexao_bd.php');

if (isset($_POST["btn_cadastrar"])) {
    $ra = $_POST["ra_aluno"];
    $atv = $_POST["nome_atividade"];
    $nota = $_POST["nota_atividade"];
    $obs = $_POST["obs_atividade"];
    $data_entrega = $_POST["data_entrega"];

    $db = new Database();
    $conn = $db->connect();

    if ($conn) {
        try {
            $query = "INSERT INTO `entrega_atividade`(`atividade_nome`, `atividade_aluno`, `atividade_nota`, `atividade_observacoes`, `atividade_data_entrega`) 
                      VALUES (:atv, :ra, :nota, :obs, :data_entrega)";
            $stmt = $conn->prepare($query);
            $stmt->execute([':atv' => $atv, ':ra' => $ra, ':nota' => $nota, ':obs' => $obs, ':data_entrega' => $data_entrega]);
            echo "Entrega cadastrada com sucesso!!!"; 
        } catch (PDOException $e) {
            echo "Erro na escrita: " . $e->getMessage();
        }
    } else {
        echo "Falha na conexão.";
    }
}

if (isset($_GET["delete_id"])) {
    $delete_id = $_GET["delete_id"];

    $db = new Database();
    $conn = $db->connect();

    if ($conn) {
        try {
            $query = "DELETE FROM `entrega_atividade` WHERE `atividade_codigo` = :delete_id";
            $stmt = $conn->prepare($query);
            $stmt->execute([':delete_id' => $delete_id]);
            echo "Entrega deletada com sucesso!!!"; 
        } catch (PDOException $e) {
            echo "Erro na exclusão: " . $e->getMessage();
        }
    } else {
        echo "Falha na conexão.";
    }
}

if (isset($_POST["btn_editar"])) {
    $atividade_codigo = $_POST["atividade_codigo"];
    $ra = $_POST["ra_aluno"];
    $atv = $_POST["nome_atividade"];
    $nota = $_POST["nota_atividade"];
    $obs = $_POST["obs_atividade"];
    $data_entrega = $_POST["data_entrega"];

    $db = new Database();
    $conn = $db->connect();

    if ($conn) {
        try {
            $query = "UPDATE `entrega_atividade` SET `atividade_nome` = :atv, `atividade_aluno` = :ra, `atividade_nota` = :nota, 
                      `atividade_observacoes` = :obs, `atividade_data_entrega` = :data_entrega WHERE `atividade_codigo` = :atividade_codigo";
            $stmt = $conn->prepare($query);
            $stmt->execute([':atv' => $atv, ':ra' => $ra, ':nota' => $nota, ':obs' => $obs, ':data_entrega' => $data_entrega, ':atividade_codigo' => $atividade_codigo]);
            echo "Entrega editada com sucesso!!!"; 
        } catch (PDOException $e) {
            echo "Erro na edição: " . $e->getMessage();
        }
    } else {
        echo "Falha na conexão.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="estilo3.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <title>Cadastrar Envio</title>
</head>

<body>
<nav>
    <div class="nav-wrapper blue accent-3">
        <ul id="nav-mobile" class="left">
            <li><img class="responsive-img" style="max-width:100px;" src="https://www.fai.com.br/vestibular/img/unifai2023.png"></li>
            <li class='col s2 center-align'><a style='color:black;' href='index.php'>Início</a></li>
            <li class='col s2 center-align'><a style='color:black;' href='ranking_geral.php'>Ranking geral</a></li>
            <li class='col s2 center-align'><a style='color:black;' href='ranking_cadastro_envio.php'>Cadastrar envio</a></li>
            <?php
            session_start();
            if(!isset($_SESSION["username"])){
                header("Location:ranking_login.php");
            } else {
                echo "<li class='col s2 center-align'>Seja bem vindo(a) ".$_SESSION["nome"]."</li>
                      <li class='col s2 center-align'><a href='ranking_sair.php'> Sair </a></li>";
            }
            ?>
        </ul>
    </div>
</nav>

<div class='container'>
    <div class='row'>
        <div class='col s12'>
            <h5>Cadastrar Entrega</h5>
            <form class="col s12" action="" method="post" onsubmit="return validateForm()">
                <div class="input-field col s6">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="icon_ra" type="number" class="validate" name="ra_aluno">
                    <label for="icon_ra">R.A. Aluno</label>
                </div>
                <div class="input-field col s6">
                    <i class="material-icons prefix">work</i>
                    <input id="icon_nome" type="text" class="validate" name="nome_atividade">
                    <label for="icon_nome">Nome Atividade</label>
                </div>
                <div class="input-field col s6">
                    <i class="material-icons prefix">equalizer</i>
                    <input id="icon_nota" type="number" min="0" max="10" step="0.5" class="validate" name="nota_atividade">
                    <label for="icon_nota">Nota</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix">message</i>
                    <input id="icon_obs" type="text" class="validate" name="obs_atividade">
                    <label for="icon_obs">Observações gerais</label>
                </div>
                <div class="input-field col s12">
                    <i class="material-icons prefix">event</i>
                    <input type="datetime-local" id="data_entrega" name="data_entrega">
                    <label for="data_entrega" class="active">Data e Hora de Entrega</label>
                </div>
                <div class="input-field col s12">
                    <input id="btn_submit" type="submit" class="btn" name="btn_cadastrar" value="Cadastrar">
                </div>
            </form>
        </div>

        <div class='col s12'>
            <h5>Entregas</h5>
            <table class="striped">
                <thead>
                    <tr>
                        <th>Atividade</th>
                        <th>Aluno</th>
                        <th>Nota</th>
                        <th>Data Entrega</th>
                        <th>Observações</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $db = new Database();
                    $conn = $db->connect();

                    if ($conn) {
                        try {
                            $query = "SELECT * FROM `entrega_atividade`";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $results = $stmt->fetchAll();

                            if ($results) {
                                foreach ($results as $linha) {
                                    echo "<tr>
                                            <td>{$linha['atividade_nome']}</td>
                                            <td>{$linha['atividade_aluno']}</td>
                                            <td>{$linha['atividade_nota']}</td>
                                            <td>{$linha['atividade_data_entrega']}</td>
                                            <td>{$linha['atividade_observacoes']}</td>
                                            <td>
                                                <a href='?delete_id={$linha['atividade_codigo']}' class='btn red'>Deletar</a>
                                                <a href='?edit_id={$linha['atividade_codigo']}' class='btn yellow darken-2'>Editar</a>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>Nenhuma entrega encontrada.</td></tr>";
                            }
                        } catch (PDOException $e) {
                            echo "<tr><td colspan='6'>Erro ao buscar entregas: " . $e->getMessage() . "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Falha na conexão.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function validateForm() {
    let ra = document.getElementById('icon_ra').value;
    let nome = document.getElementById('icon_nome').value;
    let nota = document.getElementById('icon_nota').value;
    let data = document.getElementById('data_entrega').value;
    
    if (!ra || !nome || !nota || !data) {
        alert('Todos os campos devem ser preenchidos!');
        return false;
    }
    return true;
}
</script>

</body>
</html>
