<?php 
// Importar o header (com a config de banco de dados) e verificar se o usuario é admin
include('includes/header.php'); 
require 'includes/verificar-login.php';
?>

    <div class="container mt-5">
    <!-- Incluir o alerta de mensagens -->
    <?php include('includes/alerta.php'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Visualizar Administrador
                            <a href="administradores.php" class="btn btn-outline-secondary float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                    <?php
                            if(isset($_GET['id'])) //Pegar o id do atual administrador
                            {
                                $administrador_id = mysqli_real_escape_string($con, $_GET['id']);
                                $q = "SELECT * FROM administrador WHERE id='$administrador_id' "; //Query principal
                                $qr = mysqli_query($con, $q); //Executar a query

                                if(mysqli_num_rows($qr) > 0) // Se existir dados
                                {
                                    $admin = mysqli_fetch_array($qr); //Guarda o array de dados dentro da váriavel 'admin'
                                    ?>

                                    <form>

                                        <input type="hidden" name="administrador_id" value="<?= $admin['id'];?>" class="form-control" disabled readonly>

                                        <div class="mb-3">
                                            <label for="nome" class="mb-2">Nome Completo</label>
                                            <input type="text" name="nome" value="<?= $admin['nome'];?>" class="form-control" disabled readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="usuario" class="mb-2">Usuário</label>
                                            <input type="text" name="usuario"  value="<?= $admin['usuario'];?>" class="form-control" disabled readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="senha" class="mb-2">Senha</label>
                                            <input type="text" name="senha"  value="<?= $admin['senha'];?>" class="form-control" disabled readonly>
                                        </div>
                                    </form>
                                    <?php
                                }
                                else //Senão existir nada, mostre a mensagem abaixo
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