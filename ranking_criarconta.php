<!DOCTYPE html>
<html>
<head>
    <title>Criar Conta</title>
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<body>
    <div class='container'>
        <div class='row'>
            <div class='col s4'></div>
            <div class='col s4'> 
                <h3>Criar Conta</h3>
                <?php
if (isset($_POST['btnRegister'])) {
    if (isset($_POST["entradaUser"]) && isset($_POST["new_password"])) {
        $username = $_POST["entradaUser"]; // Nome de usuário (RA)
        $new_password = $_POST["new_password"]; // Nova senha

        include('conexao_bd.php'); // Certifique-se de incluir o arquivo correto para a conexão com o banco de dados
        $db = new Database();
        $conn = $db->connect();

        if ($conn) {
            try {
                // Insira os dados na tabela 'alunos'
                $query = "INSERT INTO alunos (aluno_ra, aluno_senha) VALUES (:username, :senha)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':senha', $new_password);
                $stmt->execute();

                echo "Conta criada com sucesso. <br>";
                echo "<a href='ranking_login.php'>Voltar para a tela de login</a>";
            } catch (PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
        } else {
            echo "Falha na conexão.";
        }
    } else {
        echo "Campos do formulário não foram preenchidos.";
    }
}
?>
                <form action="" method="post">

                    <label for="entradaUser">Seu nome</label>
                    <input type="text" name="entradaUser" id="entradaUser" required>

                    <label for="entradaUser">Número do (RA)</label>
                    <input type="number" name="entradaUser" id="entradaUser" required>
                    
                    <label for="new_password">Senha</label>
                    <input type="password" name="new_password" id="new_password" required>
                    
                    <input type="submit" name="btnRegister" value="Criar Conta" class="btn blue accent-3">
                </form>
                <p> 
                    <a href='ranking_login.php'>Voltar para a tela de login</a>
                </p>
            </div>
            <div class='col s4'></div>
        </div>
    </div>
</body>
</html>
