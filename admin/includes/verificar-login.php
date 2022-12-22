<?php

if(!isset($_SESSION['usuario'])) //Se a sessão não tiver o valor 'usuario', mostre a mensagem abaixo e não permita a entrada para o painel de administrador.
{
    $_SESSION['falha'] = "Você precisa logar para acessar essa página.";
    header("Location: login.php"); //Redirecionar para a página de login
    exit(0);
}

?>