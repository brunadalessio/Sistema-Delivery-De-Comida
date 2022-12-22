<?php
// Importar o header (com a config de banco de dados) e verificar se o usuario é admin 
include('includes/header.php'); 
require 'includes/verificar-login.php';
?>

<?php
if(isset($_POST['criar'])) //Quando o botão de criar for pressionado
{
    $titulo = mysqli_real_escape_string($con, $_POST['titulo']);
    
    if(isset($_FILES['imagem_nome']['name'])) //Se inserir uma imagem
    {
        //Upload da imagem
        $imagem_nome = $_FILES['imagem_nome']['name'];
        
        //Pegar a extenção da imagem
        $ext = end(explode('.', $imagem_nome));

        //Renomear a imagem
        $imagem_nome = "Categoria_".rand(000, 999).'.'.$ext;
        $path = $_FILES['imagem_nome']['tmp_name']; 

        //Destino da imagem que será salvada
        $destino_path = "../img/categoria/".$imagem_nome;

        //Salvar a imagem
        $upload = move_uploaded_file($path, $destino_path);

        if($upload == false)
        {
            $_SESSION['falha'] = "Selecione uma imagem.";
            header("Location: criar-categoria.php");
            exit(0);
        }
    }
    else //Senão caso algo dê errado, retorna vazio
    {
        $imagem_nome="";
    }

    if(!empty($_POST['destaque'])) //Verificando se alguma opção de destaque foi selecionada
    {
        $destaque = mysqli_real_escape_string($con, $_POST['destaque']);
    } else 
    {
        $_SESSION['falha'] = "Selecione um valor de destaque/status.";
        header("Location: criar-categoria.php");
        exit(0);
    }

    if(!empty($_POST['status'])) //Verificando se alguma opção de status foi selecionada
    {
        $status = mysqli_real_escape_string($con, $_POST['status']);
    } else 
    {
        $_SESSION['falha'] = "Selecione um valor de destaque/status.";
        header("Location: criar-categoria.php");
        exit(0);
    }

    //Insira os valores no banco de dados
    $q = "INSERT INTO categoria (titulo, imagem_nome, destaque, status) VALUES 
    (
        '$titulo', 
        '$imagem_nome', 
        '$destaque', 
        '$status'
    )";

    $qr = mysqli_query($con, $q); //Executar a query

    if($qr)
    {
        $_SESSION['sucesso'] = "Categoria criada com sucesso.";
        header("Location: categorias.php");
        exit(0);
    }
    else
    {
        $_SESSION['falha'] = "Ops, aconteceu algo inesperado. Tente novamente.";
        header("Location: criar-categoria.php");
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
                        <h4>Criar Categoria
                            <a href="categorias.php" class="btn btn-outline-secondary float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Inicio do formulário -->
                        <form action="criar-categoria.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="titulo" class="mb-2">Título</label>
                                <input type="text" name="titulo" class="form-control">
                            </div>
                            <div class="mb-3">
                            <label for="imagem_nome" class="form-label">Selecione uma imagem</label>
                            <input class="form-control" type="file" name="imagem_nome" accept=".png, .jpg, .jpeg">
                            </div>
                            <div class="mb-3">
                                <label for="destaque" class="mb-2">Destaque</label>
                                <br>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="destaque" value="Sim">
                                <label class="form-check-label" for="destaque_1">Sim</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="destaque" value="Não">
                                <label class="form-check-label" for="destaque_2">Não</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="mb-2">Status</label>
                                <br>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" value="Ativo">
                                <label class="form-check-label" for="status_1">Ativo</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" value="Desativado">
                                <label class="form-check-label" for="status_2">Desativado</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="criar" class="btn btn-primary">Criar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
//Importar footer principal do front-end
include('includes/footer.php'); 
?>