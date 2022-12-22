
<?php 
// Incluir o header do pedido do front-end
include('includes/header-pedido.php'); 
?>

    <!-- Seção para buscar comidas ou descrições das comidas (Cardápio) -->
    <section class="pagina bg-dark">
      <div class="container mt-5">
      <?php 
            if(isset($_POST['buscar'])) //Quando o botão com valor buscar da página for pressionada
            {
              $buscar = $_POST['buscar']; //Guardar na váriavel 'buscar'
            }
            ?>
          <h1 class="text-center text-white mb-5">Você pesquisou: "<?php echo $buscar; ?>"</h1> <!-- Mostrar o valor da busca realizada -->
          <hr>
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
            if(isset($_POST['buscar'])) //Quando o botão com valor buscar da página for pressionada
            {
              $buscar = $_POST['buscar']; //Guardar na váriavel 'buscar'
            

              $q = "SELECT * FROM cardapio WHERE titulo LIKE '%$buscar%' OR descricao LIKE '%$buscar%' "; //Query principal para comparar o valor da busca com o banco de dados

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