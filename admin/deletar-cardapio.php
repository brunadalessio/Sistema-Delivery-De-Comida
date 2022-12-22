<?php
// Configuração do banco de dados
session_start();
require 'config/dbcon.php';
if(isset($_POST['deletar'])) // Se o botão de deletar for pressionado
{
    $cardapio_id = mysqli_real_escape_string($con, $_POST['deletar']); //Pega o ID do cardápio que deseja deletar

    $q = "DELETE FROM cardapio WHERE id='$cardapio_id'"; // Comando para deletar no banco de dados

    $qr = mysqli_query($con, $q); // Executar o comando

    if($qr)
    {
        $_SESSION['sucesso'] = "Cardápio deletado com sucesso.";
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