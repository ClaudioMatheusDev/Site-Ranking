
<!-- ranking_esquecisenha.php -->
<html>
<head>
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<body>
    <div class='container'>
        <div class='row'>
            <div class='col s4'></div>
            <div class='col s4'> 
                <h3>Redefinir Senha</h3>
                <?php
                if (isset($_POST['btnReset'])) {
                    if(isset($_POST["entradaUser"]) && isset($_POST["new_password"])) {
                        $username = $_POST["entradaUser"]; // Nome de usuário (RA)
                        $new_password = $_POST["new_password"]; // Nova senha

                        include('conexao_bd.php');
                        $db = new Database();
                        $conn = $db->connect();

                        if ($conn) {
                            try {
                                // Atualiza a senha do usuário
                                $query = "UPDATE alunos SET aluno_senha = :senha WHERE aluno_ra = :username";
                                $stmt = $conn->prepare($query);
                                $stmt->bindParam(':senha', $new_password); // Aqui estamos atribuindo a senha diretamente
                                $stmt->bindParam(':username', $username);
                                $stmt->execute();

                                echo "Senha redefinida com sucesso. <br>";
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
                    <label for="entradaUser">Nome de usuário (RA)</label>
                    <input type="number" name="entradaUser" id="entradaUser" required>
                    
                    <label for="new_password">Nova Senha</label>
                    <input type="password" name="new_password" id="new_password" required>
                    
                    <input type="submit" name="btnReset" value="Redefinir Senha" class="btn blue accent-3">
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
