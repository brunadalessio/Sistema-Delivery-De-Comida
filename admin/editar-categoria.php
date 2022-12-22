<?php
// Importar o header (com a config de banco de dados) e verificar se o usuario é admin 
include('includes/header.php');
require 'includes/verificar-login.php';
?>

<?php
if(isset($_POST['editar'])) //Se o botão de editar for pressionado
{
    $categoria_id = mysqli_real_escape_string($con, $_POST['categoria_id']);
    $titulo = mysqli_real_escape_string($con, $_POST['titulo']);
    $cat['imagem_nome'] = mysqli_real_escape_string($con, $_POST['imagem_nome']);
    
    if(isset($_FILES['imagem_nome']['name']))
    {
        //Upload da imagem
        $imagem_nome = $_FILES['imagem_nome']['name'];
        
        if($imagem_nome != "")
        {
            //Pegar a extenção da imagem
            $ext = end(explode('.', $imagem_nome));

            //Renomear a imagem
            $imagem_nome = "Categoria_".rand(000, 999).'.'.$ext;
            $path = $_FILES['imagem_nome']['tmp_name']; 

            //Destino da imagem que será salvada
            $destino_path = "../img/categoria/".$imagem_nome;

            //Salvar a imagem
            $upload = move_uploaded_file($path, $destino_path);
        }
        else
        {
            $imagem_nome= $cat['imagem_nome'];
        }
    }
    else
    {
        $imagem_nome= $cat['imagem_nome'];
    }

    if(!empty($_POST['destaque'])) 
    {
        $destaque = mysqli_real_escape_string($con, $_POST['destaque']);
    } else 
    {
        $_SESSION['falha'] = "Selecione um valor de destaque/status.";
        header("Location: categorias.php");
        exit(0);
    }

    if(!empty($_POST['status'])) 
    {
        $status = mysqli_real_escape_string($con, $_POST['status']);
    } else 
    {
        $_SESSION['falha'] = "Selecione um valor de destaque/status.";
        header("Location: categorias.php");
        exit(0);
    }

    // Atualize os dados do formulário no banco de dados
    $q = "UPDATE categoria SET titulo= '$titulo', imagem_nome= '$imagem_nome',  destaque= '$destaque', status= '$status' WHERE id='$categoria_id'";

    $qr = mysqli_query($con, $q); //Executar a query

    if($qr)
    {
        $_SESSION['sucesso'] = "Categoria editada com sucesso.";
        header("Location: categorias.php");
        exit(0);
    }
    else
    {
        $_SESSION['falha'] = "Ops, aconteceu algo inesperado. Tente novamente.";
        header("Location: categorias.php");
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
                        <h4>Editar Categoria
                            <a href="categorias.php" class="btn btn-outline-secondary float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                    <?php
                            if(isset($_GET['id']))
                            {
                                $categoria_id = mysqli_real_escape_string($con, $_GET['id']);
                                $q = "SELECT * FROM categoria WHERE id='$categoria_id' ";
                                $qr = mysqli_query($con, $q);

                                if(mysqli_num_rows($qr) > 0)
                                {
                                    $cat = mysqli_fetch_array($qr);
                                    ?>
                                <!-- Inicio do formulario -->
                                <form action="editar-categoria.php" method="POST" enctype="multipart/form-data">

                                    <div class="mb-3">
                                        <label for="titulo" class="mb-2">Título</label>
                                        <input type="text" name="titulo" class="form-control" value="<?= $cat['titulo'];?>">
                                    </div>
                                    <div class="mb-3">
                                    <label for="imagem_nome" class="form-label mt-2">Imagem atual</label>
                                    <br>
                                    <?php
                                            if($cat['imagem_nome'] != "")
                                            {
                                            ?>
                                            
                                            <img src="../img/categoria/<?= $cat['imagem_nome']; ?>" class="img-thumbnail w-25 mb-4">
                                            <?php
                                            }
                                            else
                                            {
                                                echo "Sem imagem";
                                            }
                                        ?>
                                    <input class="form-control w-50" type="file" name="imagem_nome" accept=".png, .jpg, .jpeg">
                                    </div>
                                    <div class="mb-3">
                                        <label for="destaque" class="mb-2">Destaque</label>
                                        <br>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="destaque" value="Sim" <?php if ($cat['destaque']=="Sim"){echo "checked";} ?>>
                                        <label class="form-check-label" for="destaque_1">Sim</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="destaque" value="Não" <?php if ($cat['destaque']=="Não"){echo "checked";} ?>>
                                        <label class="form-check-label" for="destaque_2">Não</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="mb-2">Status</label>
                                        <br>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="Ativo" <?php if ($cat['status']=="Ativo"){echo "checked";} ?>>
                                        <label class="form-check-label" for="status_1">Ativo</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="Desativado" <?php if ($cat['status']=="Desativado"){echo "checked";} ?>>
                                        <label class="form-check-label" for="status_2">Desativado</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <input type="hidden" name="categoria_id" value="<?= $cat['id'];?>" class="form-control">
                                        <input type="hidden" name="imagem_nome" value="<?= $cat['imagem_nome'];?>" class="form-control">
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