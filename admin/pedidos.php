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
                Tabela de Pedidos
                <!-- Gerar relatorio para tabela de pedidos -->
                <form action="includes/gerar-pdf-pedido.php" method="POST" class="float-end">
                  <button type="submit" name="gerar" class="btn btn-secondary m-1"><i class="fa-solid fa-file-pdf"></i> Gerar PDF</button>
                </form>
              </h4>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Status</th>
                    <th>Cliente</th>
                    <th>Contato</th>
                    <th>Total</th>
                    <th>Data</th>
                    <th>Endereço</th>
                    <th>Ações</th>
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
                    
                    $q = "SELECT * FROM pedido ORDER BY data_criado DESC LIMIT $inicio, $n_pg"; //Limitar com a paginação
                    $qr = mysqli_query($con, $q); //Executar a query
                    
                    
                    if(mysqli_num_rows($qr) > 0) //Se existir dados
                    {
                      foreach($qr as $ped) //Mostrar os dados da query pedidos na tabela
                      {
                                                
                        ?>
                        <tr>
                          <td ><?= $ped['id']; ?></td>
                          <td><?= $ped['item']; ?></td>
                          <td>R$ <?= $ped['preco']; ?></td>
                          <td><?= $ped['qnt']; ?></td>
                          <td class="text-center">
                          <?php 
                          if ($ped['status'] == "Pendente")
                          {
                            echo "<span class='badge bg-secondary'>Pendente</span>";
                          }
                          elseif ($ped['status'] == "Em andamento")
                          {
                            echo "<span class='badge bg-warning text-dark'>Em andamento</span>";
                          }
                          elseif ($ped['status'] == "Entregue")
                          {
                            echo "<span class='badge bg-success'>Entregue</span>";
                          }
                          else
                          {
                            echo "<span class='badge bg-danger'>Cancelado</span>";
                          }
                          
                          ?>
                          </td>
                          <td><?= $ped['nome_cliente']; ?></td>
                          <td><?= $ped['contato_cliente']; ?></td>
                          <td>R$ <?= $ped['total']; ?></td>
                          <td>
                            <?php 
                            $data = date('d/m/Y', strtotime($ped['data_criado']));
                            ?>
                            <?= $data; ?>
                          </td>
                          <!-- Mostrar a localização do cliente no google maps baseado nas coordenadas registradas -->
                          <td class="text-center w-25"><iframe src="https://www.google.com/maps?q=<?= $ped['latitude'];?>, <?= $ped['longitude'];?>&hl=pt-br;Z=14&output=embed" style="width:50%; height:50%"></iframe> </td>
                          <td class="text-center">
                          <a href="editar-pedido.php?id=<?= $ped['id']; ?>" class="btn btn-secondary"><i class="fa-solid fa-pen-to-square"></i></a>
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
        
              $q = "SELECT * FROM pedido ";
              $qr = mysqli_query($con,$q);
              $total_registro = mysqli_num_rows($qr);
              
              $total_pg = ceil($total_registro/$n_pg); //Calcular o total de paginas e mostrar os botões

              
              if($page>1) //Botão para voltar paginação
              {
                  echo "<a href='pedidos.php?page=".($page-1)."' class='btn btn-outline-secondary btn-sm m-2'><<</a>";
              }

              
              for($i=1;$i<$total_pg;$i++) //Somar as páginas e mostrar o total nos botões
              {
                  echo "<a href='pedidos.php?page=".$i."' class='btn btn-primary btn-sm m-1 '>$i</a>";
              }

              if($i>$page) //Botão para próxima paginação
              {
                  echo "<a href='pedidos.php?page=".($page+1)."' class='btn btn-outline-secondary btn-sm m-2'>>></a>";
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