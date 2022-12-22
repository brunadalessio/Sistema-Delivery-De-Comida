<?php
// Configuração do banco de dados
session_start();
require 'config/dbcon.php';
if(isset($_POST['deletar'])) // Se o botão de deletar for pressionado
{
    $categoria_id = mysqli_real_escape_string($con, $_POST['deletar']); //Pega o ID da categoria que deseja deletar

    $q = "DELETE FROM categoria WHERE id='$categoria_id'"; // Comando para deletar no banco de dados

    $qr = mysqli_query($con, $q); // Executar o comando

    if($qr)
    {
        $_SESSION['sucesso'] = "Categoria deletada com sucesso.";
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