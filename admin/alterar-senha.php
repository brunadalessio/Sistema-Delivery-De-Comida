<?php
// Importar o header (com a config de banco de dados) e verificar se o usuario é admin
include('includes/header.php');
require 'includes/verificar-login.php'; 
?>

<?php
if(isset($_POST['alterar'])) //Se o botão de alterar for pressionado
{
    $administrador_id = mysqli_real_escape_string($con, $_POST['administrador_id']);
    $senha_atual = mysqli_real_escape_string($con, md5($_POST['senha_atual']));
    $nova_senha = mysqli_real_escape_string($con, md5($_POST['nova_senha']));
    $confirmar_senha = mysqli_real_escape_string($con, md5($_POST['confirmar_senha']));

    $q = "SELECT * FROM administrador WHERE id='$administrador_id' AND senha='$senha_atual' "; //Compare a senha atual pra verificar que é o administrador responsável

    $qr = mysqli_query($con, $q); //Executar a query

    if($qr) //Se for o responsavel da conta
    {
        $cn = mysqli_num_rows($qr); //Percorrendo as linhas
        if($cn)
        {
            if($nova_senha==$confirmar_senha) //se a senha nova for compativel com a nova senha, altere a senha
            {
                $q2 = "UPDATE administrador SET senha='$nova_senha' WHERE id='$administrador_id' ";
    
                $qr2 = mysqli_query($con, $q2);
    
                $_SESSION['sucesso'] = "Senha alterada com sucesso.";
                header("Location: administradores.php");
                exit(0);
            }
            else
            {
                $_SESSION['falha'] = "Senha incorreta. Tente novamente.";
                header("Location: administradores.php");
                exit(0);
            }
        }
        else
        {
            $_SESSION['falha'] = "Senha incorreta. Tente novamente.";
            header("Location: administradores.php");
            exit(0);
        }
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
                        <h4>Alterar Senha
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
                                    <form action="alterar-senha.php" method="POST">

                                        <input type="hidden" name="administrador_id" value="<?= $admin['id'];?>" class="form-control">
                                        <div class="mb-3">
                                        <label for="senha_atual" class="mb-2">Senha Atual</label>
                                        <input type="password" name="senha_atual" class="form-control">
                                         </div>
                                        <div class="mb-3">
                                            <label for="nova_senha" class="mb-2">Nova Senha</label>
                                            <input type="password" name="nova_senha" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirmar_senha" class="mb-2">Confirmar Nova Senha</label>
                                            <input type="password" name="confirmar_senha" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" name="alterar" class="btn btn-primary">Alterar Senha</button>
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