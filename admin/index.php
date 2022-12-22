<?php
// Importar o header (com a config de banco de dados) e verificar se o usuario é admin
include('includes/header.php'); 
require 'includes/verificar-login.php';
?>
<!-- Incluir o alerta de mensagens -->
<?php include('includes/alerta.php'); ?>
<section class="pagina bg-dark">
<h1 class="text-center text-white"><i class="fa-solid fa-chart-line m-3"></i> Resumo dos registros</h1>
<hr class="text-white">
</section>
<section class="pagina">
<div class="containter">
<div class="col-md-12 d-flex justify-content-center">
<div class="row">
  <div class="col-md-3 mb-4">
  <?php 
      $q2 = "SELECT * FROM categoria"; //Select todas as categorias
      $qr2 = mysqli_query($con, $q2); //Executar query
      $c2 = mysqli_num_rows($qr2); //Contar o numero de linhas
    ?>
    <div class="card text-dark bg-light h-100" style="width: 300px">
      <div class="card-body text-center">
      <i class="fa-regular fa-folder-open fa-3x m-2"></i>
        <hr>
        <h5 class="card-title display-6 text-primary"><?php echo $c2 ?></h5>
        <h5 class="card-text">Categorias</h5>
      </div>
    </div>
  </div>
  <div class="col-md-3 mb-4">
  <?php 
      $q3 = "SELECT * FROM cardapio"; //Select todas os cardapios
      $qr3 = mysqli_query($con, $q3); //Executar query
      $c3 = mysqli_num_rows($qr3); //Contar o numero de linhas
    ?>
    <div class="card text-dark bg-light h-100" style="width: 300px">
      <div class="card-body text-center">
      <i class="fa-solid fa-pizza-slice fa-3x m-2"></i> 
        <hr>
        <h5 class="card-title display-6 text-primary"><?php echo $c3 ?></h5>
        <h5 class="card-text">Cardápios</h5>
      </div>
    </div>
  </div>
  <div class="col-md-3 mb-4">
  <?php 
      $q4 = "SELECT * FROM pedido"; //Select todas os pedidos
      $qr4 = mysqli_query($con, $q4); //Executar query
      $c4 = mysqli_num_rows($qr4); //Contar o numero de linhas
    ?>
    <div class="card text-dark bg-light  h-100" style="width: 300px">
      <div class="card-body text-center">
      <i class="fa-solid fa-truck-fast fa-3x m-2"></i>
        <hr>
        <h5 class="card-title display-6 text-primary"><?php echo $c4 ?></h5>
        <h5 class="card-text">Pedidos</h5>
      </div>
    </div>

  </div>
  <div class="col-sm-3 mb-4">
    <?php 
      $q = "SELECT sum(total) AS total FROM pedido WHERE status='Entregue'"; //Select todas os pedidos com status Entregue e some o total
      $qr = mysqli_query($con, $q); //Executar query
      $c = mysqli_fetch_assoc($qr); //Buscar os rendimentos
      $rendimento = $c['total']; //Guardar na variavel

    ?>
    <div class="card text-dark bg-light h-100" style="width: 300px">
      <div class="card-body text-center">
      <i class="fa-solid fa-money-bill-trend-up fa-3x m-2"></i>
        <hr>
        <h5 class="card-title display-6 text-primary">R$ <?php echo $rendimento ?></h5>
        <h5 class="card-text">Rendimento total</h5>

      </div>
    </div>
  </div>
  </div>
  </div>
  </div>
</section>

<?php 
//Importar footer principal do front-end
include('includes/footer.php'); 
?>
