<?php
// Importar o header (com a config de banco de dados) e verificar se o usuario é admin  
include('includes/header.php');
require 'includes/verificar-login.php'; 
?>

<?php
if(isset($_POST['editar'])) //Se o botão de editar for pressionado
{
    $cardapio_id = mysqli_real_escape_string($con, $_POST['cardapio_id']);
    $titulo = mysqli_real_escape_string($con, $_POST['titulo']);
    $descricao = mysqli_real_escape_string($con, $_POST['descricao']);
    $car['imagem'] = mysqli_real_escape_string($con, $_POST['imagem']);
    $preco = mysqli_real_escape_string($con, $_POST['preco']);
    $categoria = mysqli_real_escape_string($con, $_POST['categoria']);
    
    if(isset($_FILES['imagem']['name']))
    {
        //Upload da imagem
        $imagem = $_FILES['imagem']['name'];
        
        if($imagem != "")
        {
            //Pegar a extenção da imagem
            $ext = end(explode('.', $imagem));

            //Renomear a imagem
            $imagem = "Cardapio".rand(000, 999).'.'.$ext;
            $path = $_FILES['imagem']['tmp_name']; 

            //Destino da imagem que será salvada
            $destino_path = "../img/cardapio/".$imagem;

            //Salvar a imagem
            $upload = move_uploaded_file($path, $destino_path);
        }
        else
        {
            $imagem= $car['imagem'];
        }
    }
    else
    {
        $imagem= $car['imagem'];
    }

    if(!empty($_POST['destaque'])) 
    {
        $destaque = mysqli_real_escape_string($con, $_POST['destaque']);
    } else 
    {
        $_SESSION['falha'] = "Selecione um valor de destaque/status.";
        header("Location: cardapios.php");
        exit(0);
    }

    if(!empty($_POST['status'])) 
    {
        $status = mysqli_real_escape_string($con, $_POST['status']);
    } else 
    {
        $_SESSION['falha'] = "Selecione um valor de destaque/status.";
        header("Location: cardapios.php");
        exit(0);
    }

    // Atualize os dados do formulário no banco de dados
    $q2 = "UPDATE cardapio SET titulo= '$titulo', descricao='$descricao',  preco='$preco', imagem = '$imagem', categoria_id='$categoria', destaque= '$destaque', status= '$status' WHERE id='$cardapio_id'";

    $qr2 = mysqli_query($con, $q2); //Executar a query

    if($qr2)
    {
        $_SESSION['sucesso'] = "Cardápio editado com sucesso.";
        header("Location: cardapios.php");
        exit(0);
    }
    else
    {
        $_SESSION['falha'] = "Ops, aconteceu algo inesperado. Tente novamente.";
        header("Location: cardapios.php");
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
                        <h4>Editar Cardápio
                            <a href="cardapios.php" class="btn btn-outline-secondary float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                    <?php
                            if(isset($_GET['id']))
                            {
                                $cardapio_id = mysqli_real_escape_string($con, $_GET['id']);
                                $q = "SELECT * FROM cardapio WHERE id='$cardapio_id' ";
                                $qr = mysqli_query($con, $q);

                                if(mysqli_num_rows($qr) > 0)
                                {
                                    $car = mysqli_fetch_array($qr);
                                    ?>
                                <!-- Inicio do formulario -->
                                <form action="editar-cardapio.php" method="POST" enctype="multipart/form-data">

                                    <div class="mb-3">
                                        <label for="titulo" class="mb-2">Título</label>
                                        <input type="text" name="titulo" class="form-control" value="<?= $car['titulo'];?>">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="titulo" class="mb-2">Descrição</label>
                                        <textarea name="descricao" class="form-control"><?= $car['descricao'];?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="titulo" class="mb-2">Preço</label>
                                        <input type="number" name="preco" class="form-control w-25" value="<?= $car['preco'];?>">
                                    </div>
                                    <div class="mb-3">
                                    <label for="categoria" class="form-label">Categoria</label>
                                    <select name="categoria" class="form-select w-25">
                                    <?php
                                        $q3 = "SELECT * FROM categoria WHERE status='Ativo'";

                                        $qr3 = mysqli_query($con, $q3);

                                        if(mysqli_num_rows($qr3) > 0)
                                        {
                                        foreach($qr3 as $cat)
                                        {
                                                ?>
                                                <option <?php if($cat['id'] == $car['categoria_id']){echo "selected";} ?> value="<?= $cat['id']; ?>"><?= $cat['titulo']; ?></option>
                                                <?php
                                            }
                                        } 
                                        else
                                        {
                                            ?>
                                            <option value="0">Categoria não encontrada</option>
                                            <?php
                                        }
                                        ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                    <label for="imagem" class="form-label mt-2">Imagem atual</label>
                                    <br>
                                    <?php
                                            if($car['imagem'] != "")
                                            {
                                            ?>
                                            
                                            <img src="../img/cardapio/<?= $car['imagem']; ?>" class="img-thumbnail w-25 mb-4">
                                            <?php
                                            }
                                            else
                                            {
                                                echo "Sem imagem";
                                            }
                                        ?>
                                    <input class="form-control w-50" type="file" name="imagem" accept=".png, .jpg, .jpeg">
                                    </div>
                                    <div class="mb-3">
                                        <label for="destaque" class="mb-2">Destaque</label>
                                        <br>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="destaque" value="Sim" <?php if ($car['destaque']=="Sim"){echo "checked";} ?>>
                                        <label class="form-check-label" for="destaque_1">Sim</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="destaque" value="Não" <?php if ($car['destaque']=="Não"){echo "checked";} ?>>
                                        <label class="form-check-label" for="destaque_2">Não</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="mb-2">Status</label>
                                        <br>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="Ativo" <?php if ($car['status']=="Ativo"){echo "checked";} ?>>
                                        <label class="form-check-label" for="status_1">Ativo</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="Desativado" <?php if ($car['status']=="Desativado"){echo "checked";} ?>>
                                        <label class="form-check-label" for="status_2">Desativado</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <input type="hidden" name="cardapio_id" value="<?= $car['id'];?>" class="form-control">
                                        <input type="hidden" name="imagem" value="<?= $car['imagem'];?>" class="form-control">
                                        <button type="submit" name="editar" class="btn btn-primary">Editar</button>
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