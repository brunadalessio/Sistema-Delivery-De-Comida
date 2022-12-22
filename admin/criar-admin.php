<?php
// Importar o header (com a config de banco de dados) e verificar se o usuario é admin 
include('includes/header.php'); 
require 'includes/verificar-login.php';
?>

<?php
if(isset($_POST['criar'])) //Quando o botão de criar for pressionado
{
    $nome = mysqli_real_escape_string($con, $_POST['nome']);
    $usuario = mysqli_real_escape_string($con, $_POST['usuario']);
    $senha = mysqli_real_escape_string($con, md5($_POST['senha']));

    //Insira os valores no banco de dados
    $q = "INSERT INTO administrador (nome, usuario, senha) VALUES 
    (
        '$nome', 
        '$usuario', 
        '$senha'
    )";

    $qr = mysqli_query($con, $q); //Executar a query

    if($qr)
    {
        $_SESSION['sucesso'] = "Administrador criado com sucesso.";
        header("Location: administradores.php");
        exit(0);
    }
    else
    {
        $_SESSION['falha'] = "Ops, aconteceu algo inesperado. Tente novamente.";
        header("Location: criar-admin.php");
        exit(0);
    }
}
?>

    <div class="container mt-5">
    <!-- Incluir o alerta de mensagens -->
    <?php include('includes/alerta.php'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Cadastrar Administrador
                            <a href="administradores.php" class="btn btn-outline-secondary float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Inicio do formulário -->
                        <form action="criar-admin.php" method="POST">
                            <div class="mb-3">
                                <label for="nome" class="mb-2">Nome Completo</label>
                                <input type="text" name="nome" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="usuario" class="mb-2">Usuário</label>
                                <input type="text" name="usuario" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="senha" class="mb-2">Senha</label>
                                <input type="password" name="senha" class="form-control">
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="criar" class="btn btn-primary">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
//Importar footer principal do front-end
include('includes/footer.php'); 
?>