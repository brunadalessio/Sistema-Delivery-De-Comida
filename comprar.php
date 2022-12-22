<?php 
// Incluir o header do pedido do front-end
include('includes/header-pedido.php'); 
?>


<?php
//Inicializar a variavel 'total' para gerar o valor preço total da compra
$total = 0;

//Quando o botão de comprar for pressionado pegue os dados dos formulários e insere na tabela 'pedido'
if(isset($_POST['comprar']))
{
    //Pegar as informações da comida atual
    $item = mysqli_real_escape_string($con, $_POST['item']);
    $preco = mysqli_real_escape_string($con, $_POST['preco']);
    $qnt = mysqli_real_escape_string($con, $_POST['qnt']);

    //Calculo do preço total * quantidade (unidade)
    $total = ((int)$preco * (int)$qnt);

    //Pegar a data e hora atual (A formatação em português será executada na View no painel do Administrador e relatórios)
    $data_criado = date('Y-m-d H:i:s');

    //Inserir o status como pendente na primeira requisição
    $status = "Pendente";

    //Pegar as informações do cliente e latidude/longitude para API da Geolocalização do Google (O cliente necessita permitir no browser para que isso seja executado)
    $nome_cliente = mysqli_real_escape_string($con, $_POST['nome_cliente']);
    $contato_cliente = mysqli_real_escape_string($con, $_POST['contato_cliente']);
    $latitude = mysqli_real_escape_string($con, $_POST['latitude']);
    $longitude = mysqli_real_escape_string($con, $_POST['longitude']);

    //Query para inserir os dados no banco de dados
    $q2 = "INSERT INTO pedido (item, preco, qnt, status, nome_cliente, contato_cliente, latitude, longitude, total, data_criado) VALUES 
    (
        '$item', 
        '$preco', 
        '$qnt',  
        '$status', 
        '$nome_cliente', 
        '$contato_cliente', 
        '$latitude', 
        '$longitude',
        '$total',
        '$data_criado'
    )";

    //Executar a query(conexão, query)
    $qr2 = mysqli_query($con, $q2);

    //Se a query for executada, mostre alerta de sucesso
    if($qr2)
    {
        $_SESSION['sucesso'] = "Pedido enviado com sucesso.";
        header("Location: index.php");
        exit(0);
    }
    else //Senão, mostre alerta de falha
    {
        $_SESSION['falha'] = "Ops, aconteceu algo inesperado. Tente novamente.";
        header("Location: index.php");
        exit(0);
    }
}
?>
<!-- Mostrar os detalhes do Pedido -->
<div class="container mt-5">
        <div class="row">
            <div class="col-md-12  d-flex justify-content-center" >
                <div class="card">
                    <div class="card-header">
                        <h4>Detalhes do Pedido
                            <a href="index.php" class="btn btn-outline-secondary float-end">Voltar</a>
                        </h4>
                    </div>
                    <!-- Inicio da Form -->
                    <form action="comprar.php" method="POST" class="meuForm">
                    <div class="card-body">
                            <?php if(isset($_GET['cardapio_id'])) //Pegar o ID do cardápio que foi selecionado na página anterior
                            {
                                $cardapio_id = mysqli_real_escape_string($con, $_GET['cardapio_id']);
                                $q = "SELECT * FROM cardapio WHERE id='$cardapio_id' "; //Query Principal
                                $qr = mysqli_query($con, $q); //Executar a Query

                                if(mysqli_num_rows($qr) > 0) //Se existir valores no banco de dados
                                {   //Guarda os valores na variavel 'car' e mostre os registros
                                    $car = mysqli_fetch_array($qr);?>
                                    <div class="col-md-12 d-flex justify-content-center">
                                        <div class="card mb-3 border-0" >
                                            <div class="row g-0">
                                            <div class="col-md-3" >
                                            <?php
                                                if($car['imagem'] != "")
                                                {
                                                ?>
                                                <br>
                                                    <img src="img/cardapio/<?= $car['imagem']; ?>" class="img-thumbnail v-100">
                                                <?php
                                                }
                                                else
                                                {
                                                    echo "<input type=text value=Indefinido class=form-control disabled readonly>";
                                                }?>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="card-body mt-3 ">
                                                <h5 class="card-title"><?= $car['titulo'];?></h5>
                                                <input type="hidden" name="item" class="form-control w-50" value="<?= $car['titulo'];?>">
                                                <h6 class="card-title">R$ <?= $car['preco'];?></h6>
                                                <input type="hidden" name="preco" class="form-control w-50" value="<?= $car['preco'];?>">
                                                <p class="card-text"><?= $car['descricao'];?></p>
                                                <hr>
                                                <label for="nome" class="mb-2">Quantidade: </label>
                                                <input type="number" name="qnt" class="form-control w-25" min="0">
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                else //Caso não exista nenhum registro com o determinado ID no banco de dados, mostrar a mensagem abaixo
                                {
                                    echo "<h4> ID não encontrado </h4>";
                                }
                            }
                            ?>
                                    <hr>
                                        <!-- Campos para informações do Cliente -->
                                        <div class="mb-3">
                                            <label for="nome_cliente" class="mb-2">Nome Completo</label>
                                            <input type="text" name="nome_cliente" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="contato_cliente" class="mb-2">Telefone</label>
                                            <input type="text" name="contato_cliente" class="form-control">
                                        </div>
                                        <!-- Campos HIDDEN para inserir a latitude e longitude no banco de dados, após a permissão do cliente para registrar a localização atual -->
                                        <div class="mb-3">
                                        <input type="hidden" name="latitude" class="form-control" value="">
                                        </div>
                                        <div class="mb-3">
                                        <input type="hidden" name="longitude" class="form-control" value="">
                                        </div>
                                        <hr>
                                        <div class="mb-3">
                                            <button type="submit" name="comprar" class="btn btn-primary float-end mb-3">Pedir agora</button>
                                        </div>
                                    </form>

                        <!-- Inicio do Script da API de Geolocalização do Google (Versão 3) -->
                        <script type="text/javascript">
                            // Função para pedir permissão do cliente e registrar sua geolocalização
                            function registrarLocalizacao()
                            {
                                if(navigator.geolocation){
                                    navigator.geolocation.getCurrentPosition(mostrarPosicao, mostrarErro);
                                }
                            }
                            // Função para inserir os dados, após a permissão, nos formulários de latitude e longitude
                            function mostrarPosicao(posicao){

                                document.querySelector('.meuForm input[name="latitude"]').value = posicao.coords.latitude;
                                document.querySelector('.meuForm input[name="longitude"]').value = posicao.coords.longitude;

                            }
                            // Caso houver algum erro no sistema ou requerimento, mostre as mensagens abaixo
                            function mostrarErro(erro){
                                switch(erro.code){
                                    case erro.PERMISSION_DENIED:
                                        alert("Você precisa permitir a geolocalização para prosseguir com a compra.");
                                        location.reload();
                                        break;
                                    case erro.POSITION_UNAVAILABLE:
                                        alert("A informação desse local está indisponível.");
                                        break;
                                    case erro.UNKNOWN_ERROR:
                                        alert("Um erro desconhecido aconteceu. Tente novamente.");
                                        break;
                                    case erro.REQUEST_DENIED:
                                        alert("Requisição negada. Tente novamente.");
                                        break;
                                }
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
// Incluir o footer principal do front-end
include('includes/footer.php'); 
?>
