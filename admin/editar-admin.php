<?php
// Importar o header (com a config de banco de dados) e verificar se o usuario é admin  
include('includes/header.php');
require 'includes/verificar-login.php'; 
?>

<?php
if(isset($_POST['editar'])) //Se o botão de editar for pressionado
{
    $administrador_id = mysqli_real_escape_string($con, $_POST['administrador_id']);
    $nome = mysqli_real_escape_string($con, $_POST['nome']);
    $usuario = mysqli_real_escape_string($con, $_POST['usuario']);

    // Atualize os dados do formulário no banco de dados
    $q = "UPDATE administrador SET nome='$nome', usuario='$usuario' WHERE id='$administrador_id'";

    $qr = mysqli_query($con, $q); //Executar a query

    if($qr)
    {
        $_SESSION['sucesso'] = "Administrador editado com sucesso.";
        header("Location: administradores.php");
        exit(0);
    }
    else
    {
        $_SESSION['falha'] = "Ops, aconteceu algo inesperado. Tente novamente.";
        header("Location: administradores.php");
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
                        <h4>Editar Administrador
                            <a href="administradores.php" class="btn btn-outline-secondary float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                    <?php
                            if(isset($_GET['id']))
                            {
                                $administrador_id = mysqli_real_escape_string($con, $_GET['id']);
                                $q = "SELECT * FROM administrador WHERE id='$administrador_id' ";
                                $qr = mysqli_query($con, $q);

                                if(mysqli_num_rows($qr) > 0)
                                {
                                    $admin = mysqli_fetch_array($qr);
                                    ?>
                                    <!-- Inicio do formulario -->
                                    <form action="editar-admin.php" method="POST">

                                        <input type="hidden" name="administrador_id" value="<?= $admin['id'];?>" class="form-control">

                                        <div class="mb-3">
                                            <label for="nome" class="mb-2">Nome Completo</label>
                                            <input type="text" name="nome" value="<?= $admin['nome'];?>" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="usuario" class="mb-2">Usuário</label>
                                            <input type="text" name="usuario"  value="<?= $admin['usuario'];?>" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" name="editar" class="btn btn-primary">Editar</button>
                                        </div>
                                    </form>
                                    <?php
                                }
                                else
                                {
                                    echo "<h4> ID não encontrado </h4>";
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
//Importar footer principal do front-end
include('includes/footer.php'); 
?>