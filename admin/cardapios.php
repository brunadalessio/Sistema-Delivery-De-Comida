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
              <h4>
                Tabela de Cardápios
                <!-- Criar novo cardapio -->
                <a href="criar-cardapio.php" class="btn btn-primary float-end m-1"><i class="fa-solid fa-plus"></i> Novo Cardápio</a>
                <!-- Gerar relatorio para tabela de cardápio -->
                <form action="includes/gerar-pdf-cardapio.php" method="POST" class="float-end">
                  <button type="submit" name="gerar" class="btn btn-secondary m-1"><i class="fa-solid fa-file-pdf"></i> Gerar PDF</button>
                </form>
              </h4>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Categoria</th>
                    <th>Destaque</th>
                    <th>Status</th>
                    <th>Imagem</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if(isset($_GET['page'])) //Guardar variavel na paginação
                    {
                      $page = $_GET['page']; 
                    }
                    else
                    {
                      $page = 1;
                    }
                    
                    $n_pg = 5; // Número de dados mostrado por páginas
                    $inicio = ($page-1)*5; //Calculo para pagina inicial
                    
                    $q = "SELECT * FROM cardapio LIMIT $inicio, $n_pg"; //Limitar com a paginação
                    $qr = mysqli_query($con, $q); //Executar a query

                    if(mysqli_num_rows($qr) > 0) //Se existir dados
                    {
                      foreach($qr as $car) //Mostrar os dados da query cardapios na tabela
                      {
                        ?>
                        <tr>
                          <td><?= $car['id']; ?></td>
                          <td><?= $car['titulo']; ?></td>
                          <td><?= $car['descricao']; ?></td>
                          <td><?= $car['preco']; ?></td>
                          <td><?= $car['categoria_id']; ?></td>
                          <td><?= $car['destaque']; ?></td>
                          <td><?= $car['status']; ?></td>
                          <td style="width:20%;">
                            <?php
                            if($car['imagem'] != "") //Se a imagem NÃO for vazia
                            {
                              ?>
                              
                              <img src="../img/cardapio/<?= $car['imagem']; ?>" class="img-thumbnail w-50">
                              <?php
                            }
                            else
                            {
                              echo "Sem imagem";
                            }
                          ?>
                          </td>
                          <td class="text-center" style="width:15%;">
                          <a href="visualizar-cardapio.php?id=<?= $car['id']; ?>" class="btn btn-secondary"><i class="fa-solid fa-eye"></i></a>
                          <a href="editar-cardapio.php?id=<?= $car['id']; ?>" class="btn btn-secondary"><i class="fa-solid fa-pen-to-square"></i></a>
                          <form action="deletar-cardapio.php" method="POST" class="d-inline">
                            <button type="submit" name="deletar" value="<?= $car['id']; ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                          </form>
                          </td>
                        </tr>
                        <?php
                      }
                    }
                    else //Senão existir dados, mostre a mensagem abaixo
                    {
                      echo "<h5> Nenhum registro encontrado </h5>";
                    }
                  ?>
                </tbody>
              </table> 
              <div class="text-center">
              <?php 
        
              $q = "SELECT * FROM cardapio ";
              $qr = mysqli_query($con,$q);
              $total_registro = mysqli_num_rows($qr); 
              
              $total_pg = ceil($total_registro/$n_pg); //Calcular o total de paginas e mostrar os botões

              
              if($page>1) //Botão para voltar paginação
              {
                  echo "<a href='cardapios.php?page=".($page-1)."' class='btn btn-outline-secondary btn-sm m-2'><<</a>";
              }

              
              for($i=1;$i<$total_pg;$i++) //Somar as páginas e mostrar o total nos botões
              {
                  echo "<a href='cardapios.php?page=".$i."' class='btn btn-primary btn-sm m-1 '>$i</a>";
              }

              if($i>$page) //Botão para próxima paginação
              {
                  echo "<a href='cardapios.php?page=".($page+1)."' class='btn btn-outline-secondary btn-sm m-2'>>></a>";
              }

              ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php
//Importar footer principal do front-end
include('includes/footer.php'); 
?>