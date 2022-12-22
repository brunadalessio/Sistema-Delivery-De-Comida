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
                        <h4>Visualizar Cardápio
                            <a href="cardapios.php" class="btn btn-outline-secondary float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                    <?php
                            if(isset($_GET['id'])) //Pegar o id do atual cardápio
                            {
                                $cardapio_id = mysqli_real_escape_string($con, $_GET['id']);
                                $q = "SELECT * FROM cardapio WHERE id='$cardapio_id' "; //Query principal
                                $qr = mysqli_query($con, $q); //Executar a query

                                if(mysqli_num_rows($qr) > 0) // Se existir dados 
                                {
                                    $car = mysqli_fetch_array($qr); //Guarda o array de dados dentro da váriavel 'car'
                                    ?>

                                    <form>

                                        <input type="hidden" name="cardapio_id" value="<?= $car['id'];?>" class="form-control" disabled readonly>

                                        <div class="mb-3">
                                            <label for="titulo" class="mb-2">Título</label>
                                            <input type="text" name="nome" value="<?= $car['titulo'];?>" class="form-control" disabled readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="titulo" class="mb-2">Preço</label>
                                            <input type="text" name="preco" value="<?= $car['preco'];?>" class="form-control w-25" disabled readonly>
                                        </div>
                            
                                        <div class="mb-3">
                                            <label for="titulo" class="mb-2">Descrição</label>
                                            <textarea name="descricao" class="form-control" disabled readonly><?= $car['descricao'];?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="titulo" class="mb-2">Categoria</label>
                                            <input type="text" name="categoria_id" value="<?= $car['categoria_id'];?>" class="form-control w-25" disabled readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="imagem" class="mb-2">Imagem</label>
                                            <?php
                                            if($car['imagem'] != "")
                                            {
                                            ?>
                                            <br>
                                            <img src="../img/cardapio/<?= $car['imagem']; ?>" class="img-thumbnail" width="15%;">
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
                                            <input type="text" name="destaque"  value="<?= $car['destaque'];?>" class="form-control w-25" disabled readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="mb-2">Status</label>
                                            <input type="text" name="status"  value="<?= $car['status'];?>" class="form-control w-25" width="15%;" disabled readonly>
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