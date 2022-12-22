<?php
// Configuração do banco de dados
session_start();
require 'config/dbcon.php';
if(isset($_POST['deletar'])) // Se o botão de deletar for pressionado
{
    $administrador_id = mysqli_real_escape_string($con, $_POST['deletar']); //Pega o ID do administrador que deseja deletar

    $q = "DELETE FROM administrador WHERE id='$administrador_id'"; // Comando para deletar no banco de dados

    $qr = mysqli_query($con, $q); // Executar o comando

    if($qr)
    {
        $_SESSION['sucesso'] = "Administrador deletado com sucesso.";
        header("Location: administradores.php");
        exit(0);
    }
    else
    {
        $_SESSION['falha'] = "Ops, aconteceu algo inesperado. Tente novamente.";
        header("Location: administradores.php");
        exit(0);
    }
}
?>