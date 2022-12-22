<?php 
// Incluir o header principal do front-end
include('includes/header.php'); 
?>

<!-- Incluir os alertas das requisições do back-end PHP -->
<?php include('admin/includes/alerta.php'); ?>

<!-- Seção para buscar comidas ou descrições das comidas (Cardápio) -->
  <section class="pagina bg-dark">
      <div class="container mt-5">
          <h1 class="text-center text-white mb-5">Faça seu pedido com os melhores pratos agora! <i class="fa-solid fa-thumbs-up"></i></h1>
          <hr>
          <form action="buscar.php" method="POST" role="search" class="d-flex justify-content-center" method="POST">
              <input class="form-control form-control-lg" name="buscar" type="search" placeholder="Buscar..." style="width:40%">
              <button class="btn btn-secondary btn-lg" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
          </form>
      </div>
  </section>

<!-- Seção para mostrar Categorias registrados no banco de dados que possui os valores no status: 'Ativo' e destaque: 'Sim' -->
    <section class="pagina" id="categoria">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                  <?php 
                    $q = "SELECT * FROM categoria WHERE status='Ativo' AND destaque='Sim'"; //Query principal
                    $qr = mysqli_query($con, $q); //Executar a query

                    if(mysqli_num_rows($qr) > 0) //Se existir valores no banco de dados
                    {
                      foreach($qr as $cat) //Loop para mostrar os dados
                      {
                        ?>
                        <a href = "cardapio.php?categoria_id=<?= $cat['id']; ?>"> 
                        <div class="col">
                          <div class="card">
                          <?php
                            if($cat['imagem_nome'] != "")
                            {
                              ?>
                              
                              <img src="img/categoria/<?= $cat['imagem_nome']; ?>" class="card-img-top">
                              <?php
                            }
                            else
                            {
                              echo "Sem imagem";
                            }
                          ?>
                            <h3 class="texto-flutuante text-white"><?= $cat['titulo']; ?> </h3>
                          </div>
                        </div>
                        </a>
                <?php
                      }
                    }
                    else //Caso não exista nenhum registro no banco de dados, mostrar a mensagem abaixo
                    {
                      echo "<h5> Nenhum registro encontrado </h5>";
                    }
                  ?>
          </div> 
        </div>
    </section>

<!-- Seção para mostrar Cardápios registrados no banco de dados que possui os valores no status: 'Ativo' e destaque: 'Sim' -->
    <section class="pagina bg-light" id="cardapio">
        <div class="container">
            <div class="row">
              <?php
                  $q = "SELECT * FROM cardapio WHERE status='Ativo' AND destaque='Sim'"; //Query principal
                  $qr = mysqli_query($con, $q); //Executar a query

                  if(mysqli_num_rows($qr) > 0) //Se existir valores no banco de dados
                  {
                    foreach($qr as $car) //Loop para mostrar os dados
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
                      ?>
                </div>
              </div>
        </div>
    </section>

<?php 
// Incluir o footer principal do front-end
include('includes/footer.php'); 
?>