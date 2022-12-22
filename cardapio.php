<?php 
// Incluir o header do pedido do front-end
include('includes/header-pedido.php'); 
?>
    
    <!-- Seção para buscar comidas ou descrições das comidas (Cardápio) baseadas na Categoria selecionada -->
    <section class="pagina bg-dark">
      <div class="container mt-5">
      <?php
          if(isset($_GET['categoria_id'])) //Pegar o ID da categoria que foi selecionado na página anterior
          {
            $categoria_id = mysqli_real_escape_string($con, $_GET['categoria_id']);
            $q = "SELECT titulo FROM categoria WHERE id='$categoria_id' "; //Selecionar o titulo da categoria atual
            $qr = mysqli_query($con, $q);

            if(mysqli_num_rows($qr) > 0) //Se existir esse ID
            {
                $cat = mysqli_fetch_array($qr); //Buscar os registros e guardar na variavel 'cat'
                ?>
              <h1 class="text-center text-white mb-5">Cardápio em: "<?= $cat['titulo']; ?>"</h1> <!-- Mostrar o titulo da categoria selecionada -->
          <?php
          }
          else //Senao existir o ID selecionado, mostrar a mensagem abaixo
          {
              echo "<div class=text-center><h4 class=text-white> ID não encontrado </h4></div>";
          }
        }
          ?>
          <hr>
          <!-- Formulário para a busca de comidas/descrição -->
          <form action="buscar.php" method="POST" role="search" class="d-flex justify-content-center" method="POST">
              <input class="form-control form-control-lg" name="buscar" type="search" placeholder="Buscar..." style="width:40%">
              <button class="btn btn-secondary btn-lg" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
          </form>
      </div>
  </section>


<!-- Seção para mostrar Cardápios registrados no banco de dados -->
     <section class="pagina bg-light" id="cardapio">
        <div class="container">
            <div class="row">
              <?php
                if(isset($_GET['categoria_id'])) //Pegar o ID da categoria que foi selecionado na página anterior
                {
                  $categoria_id = mysqli_real_escape_string($con, $_GET['categoria_id']);
                  $q2 = "SELECT * FROM cardapio WHERE categoria_id='$categoria_id'"; //Query principal
                  $qr2 = mysqli_query($con, $q2); //Executar a query

                  if(mysqli_num_rows($qr2) > 0) //Se existir valores no banco de dados
                  {
                    foreach($qr2 as $car) //Loop para mostrar os dados
                    {
                  ?>
                <div class="col-sm-6">
                    <div class="card mb-5">
                        <div class="row g-0">

                          <div class="col-md-4">
                          <?php
                            if($car['imagem'] != "")
                            {
                              ?>
                              
                              <img src="img/cardapio/<?= $car['imagem']; ?>" class="img-fluid rounded-start">
                              <?php
                            }
                            else
                            {
                              echo "Sem imagem";
                            }
                          ?>
                          </div>
                          <div class="col-md-8">
                            <div class="card-body">
                              <h5 class="card-title"><?= $car['titulo']; ?></h5>
                              <h6 class="card-title">R$ <?= $car['preco']; ?></h6>
                              <p class="card-text"><?= $car['descricao']; ?></p>
                              <hr>
                              <a href="comprar.php?cardapio_id=<?= $car['id']; ?> " class="btn btn-primary float-end">Pedir agora</a>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
                   <?php
                          }
                        }
                        else //Caso não exista nenhum registro no banco de dados, mostrar a mensagem abaixo
                        {
                          echo "<h5 class=text-center> Nenhum registro encontrado </h5>";
                        }
                      }
                      ?>
                </div>
              </div>
        </div>
    </section>


<?php 
// Incluir o footer principal do front-end
include('includes/footer.php'); 
?>