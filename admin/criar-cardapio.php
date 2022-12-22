<?php
// Importar o header (com a config de banco de dados) e verificar se o usuario é admin 
include('includes/header.php'); 
require 'includes/verificar-login.php';
?>

<?php
if(isset($_POST['criar'])) //Quando o botão de criar for pressionado
{
    $titulo = mysqli_real_escape_string($con, $_POST['titulo']);
    $descricao = mysqli_real_escape_string($con, $_POST['descricao']);
    $preco = mysqli_real_escape_string($con, $_POST['preco']);
    $categoria = mysqli_real_escape_string($con, $_POST['categoria']);

    if(isset($_FILES['imagem']['name'])) //Se inserir uma imagem
    {
        //Upload da imagem
        $imagem = $_FILES['imagem']['name'];
        
        //Pegar a extenção da imagem
        $ext = end(explode('.',$imagem));

        //Renomear a imagem
        $imagem = "Cardapio_".rand(000, 999).'.'.$ext;
        $path = $_FILES['imagem']['tmp_name']; 

        //Destino da imagem que será salvada
        $destino_path = "../img/cardapio/".$imagem;

        //Salvar a imagem
        $upload = move_uploaded_file($path, $destino_path);

        if($upload == false)
        {
            $_SESSION['falha'] = "Selecione uma imagem.";
            header("Location: criar-cardapio.php");
            exit(0);
        }
    }
    else //Senão caso algo dê errado, retorna vazio
    {
        $imagem="";
    }

    if(!empty($_POST['destaque'])) //Verificando se alguma opção de destaque foi selecionada
    {
        $destaque = mysqli_real_escape_string($con, $_POST['destaque']);
    } else 
    {
        $_SESSION['falha'] = "Selecione um valor de destaque/status.";
        header("Location: criar-cardapio.php");
        exit(0);
    }

    if(!empty($_POST['status'])) //Verificando se alguma opção de status foi selecionada
    {
        $status = mysqli_real_escape_string($con, $_POST['status']);
    } else 
    {
        $_SESSION['falha'] = "Selecione um valor de destaque/status.";
        header("Location: criar-cardapio.php");
        exit(0);
    }

    //Insira os valores no banco de dados
    $q2 = "INSERT INTO cardapio (titulo, descricao, preco, imagem, categoria_id, destaque, status) VALUES 
    (
        '$titulo', 
        '$descricao', 
        '$preco', 
        '$imagem', 
        '$categoria', 
        '$destaque', 
        '$status'
    )";

    $qr2 = mysqli_query($con, $q2); //Executar a query

    if($qr2)
    {
        $_SESSION['sucesso'] = "Cardápio criado com sucesso.";
        header("Location: cardapios.php");
        exit(0);
    }
    else
    {
        $_SESSION['falha'] = "Ops, aconteceu algo inesperado. Tente novamente.";
        header("Location: criar-cardapio.php");
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
                        <h4>Criar Cardápio
                            <a href="cardapios.php" class="btn btn-outline-secondary float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Inicio do formulário -->
                        <form action="criar-cardapio.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="titulo" class="mb-2">Título</label>
                                <input type="text" name="titulo" class="form-control">
                            </div>
                            <div class="mb-3">
                                <textarea name="descricao" class="form-control" placeholder="Descrição da comida"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="preco" class="mb-2">Preço</label>
                                <input type="number" name="preco" class="form-control w-25">
                            </div>
                            <div class="mb-3">
                                <label for="imagem" class="form-label">Selecione uma imagem</label>
                                <input class="form-control" type="file" name="imagem" accept=".png, .jpg, .jpeg">
                            </div>
                            <div class="mb-3">
                            <label for="categoria" class="form-label">Categoria</label>
                            <select name="categoria" class="form-select w-25">
                            <?php
                                $q = "SELECT * FROM categoria WHERE status='Ativo'"; //Mostrar as categorias que estão ativas para serem selecionadas no formulário

                                $qr = mysqli_query($con, $q);

                                if(mysqli_num_rows($qr) > 0)
                                {
                                  foreach($qr as $cat)
                                  {
                                        ?>
                                        <option value="<?= $cat['id']; ?>"><?= $cat['titulo']; ?></option>
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
                            <hr>
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