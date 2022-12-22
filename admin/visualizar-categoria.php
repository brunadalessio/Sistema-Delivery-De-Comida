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
                        <h4>Visualizar Categoria
                            <a href="categorias.php" class="btn btn-outline-secondary float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                    <?php
                            if(isset($_GET['id'])) //Pegar o id da atual categoria
                            {
                                $categoria_id = mysqli_real_escape_string($con, $_GET['id']); 
                                $q = "SELECT * FROM categoria WHERE id='$categoria_id' "; //Query principal
                                $qr = mysqli_query($con, $q); //Executar a query

                                if(mysqli_num_rows($qr) > 0) // Se existir dados 
                                {
                                    $cat = mysqli_fetch_array($qr); //Guarda o array de dados dentro da váriavel 'cat'
                                    ?>

                                    <form>

                                        <input type="hidden" name="categoria_id" value="<?= $cat['id'];?>" class="form-control" disabled readonly>

                                        <div class="mb-3">
                                            <label for="titulo" class="mb-2">Título</label>
                                            <input type="text" name="nome" value="<?= $cat['titulo'];?>" class="form-control" disabled readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="imagem_nome" class="mb-2">Imagem</label>
                                            <?php
                                            if($cat['imagem_nome'] != "")
                                            {
                                            ?>
                                            <br>
                                            <img src="../img/categoria/<?= $cat['imagem_nome']; ?>" class="img-thumbnail" width="15%;">
                                            <?php
                                            }
                                            else
                                            {
                                            echo "<input type=text value=Indefinido class=form-control disabled readonly>";
                                            }
                                        ?>
                                        </div>
                                        <div class="mb-3">
                                            <label for="destaque" class="mb-2">Destacado</label>
                                            <input type="text" name="destaque"  value="<?= $cat['destaque'];?>" class="form-control w-25" disabled readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="mb-2">Status</label>
                                            <input type="text" name="status"  value="<?= $cat['status'];?>" class="form-control w-25" width="15%;" disabled readonly>
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