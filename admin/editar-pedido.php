<?php
// Importar o header (com a config de banco de dados) e verificar se o usuario é admin
include('includes/header.php');
require 'includes/verificar-login.php'; 
?>

<?php
if(isset($_POST['editar'])) //Se o botão de editar for pressionado
{
    $pedido_id = mysqli_real_escape_string($con, $_POST['pedido_id']);
    $item = mysqli_real_escape_string($con, $_POST['item']);
    $preco = mysqli_real_escape_string($con, $_POST['preco']);
    $nome_cliente = mysqli_real_escape_string($con, $_POST['nome_cliente']);
    $contato_cliente = mysqli_real_escape_string($con, $_POST['contato_cliente']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    
    // Atualize os dados do formulário no banco de dados
    $q = "UPDATE pedido SET
    item='$item', 
    preco='$preco', 
    nome_cliente='$nome_cliente', 
    contato_cliente='$contato_cliente',
    status='$status'
    WHERE id='$pedido_id'";

    $qr = mysqli_query($con, $q); //Executar a query

    if($qr)
    {
        $_SESSION['sucesso'] = "Pedido editado com sucesso.";
        header("Location: pedidos.php");
        exit(0);
    }
    else
    {
        $_SESSION['falha'] = "Ops, aconteceu algo inesperado. Tente novamente.";
        header("Location: pedidos.php");
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
                        <h4>Editar Pedido
                            <a href="pedidos.php" class="btn btn-outline-secondary float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                    <?php
                            if(isset($_GET['id']))
                            {
                                $pedido_id = mysqli_real_escape_string($con, $_GET['id']);
                                $q = "SELECT * FROM pedido WHERE id='$pedido_id' ";
                                $qr = mysqli_query($con, $q);

                                if(mysqli_num_rows($qr) > 0)
                                {
                                    $ped = mysqli_fetch_array($qr);
                                    ?>
                                    <!-- Inicio do formulario -->
                                    <form action="editar-pedido.php" method="POST">

                                        <input type="hidden" name="pedido_id" value="<?= $ped['id'];?>" class="form-control">

                                        <div class="mb-3">
                                            <label for="item" class="mb-2">Item</label>
                                            <input type="text" name="item" value="<?= $ped['item'];?>" class="form-control w-50" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="preco" class="mb-2">Preço por unidade</label>
                                            <input type="text" name="preco"  value="<?= $ped['preco'];?>" class="form-control w-25" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="usuario" class="mb-2">Cliente</label>
                                            <input type="text" name="nome_cliente"  value="<?= $ped['nome_cliente'];?>" class="form-control w-50">
                                        </div>
                                        <div class="mb-3">
                                            <label for="usuario" class="mb-2">Contato</label>
                                            <input type="text" name="contato_cliente"  value="<?= $ped['contato_cliente'];?>" class="form-control w-50">
                                        </div>
                                        <div class="mb-3">
                                            <label for="usuario" class="mb-2">Status</label>
                                            <select class="form-select w-25" aria-label="Default select example" name="status">
                                            <option <?php if ($ped['status']=="Pendente"){echo "selected";}?>>Pendente</option>
                                            <option <?php if ($ped['status']=="Em andamento"){echo "selected";}?>>Em andamento</option>
                                            <option <?php if ($ped['status']=="Entregue"){echo "selected";}?>>Entregue</option>
                                            <option <?php if ($ped['status']=="Cancelado"){echo "selected";}?>>Cancelado</option>
                                        </select>
                                        </div>

                                        <hr>
                                        <div class="mb-3">
                                            <button type="submit" name="editar" class="btn btn-primary float-end">Editar</button>
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