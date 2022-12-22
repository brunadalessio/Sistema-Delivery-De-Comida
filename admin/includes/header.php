<?php
  //Começar a sessão e conectar ao banco de dados
  session_start();
  require 'config/dbcon.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- Bootstrap CSS Versão 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>

<body>
    <!-- Navbar principal do Front-end -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.php"><i class="fa-solid fa-bowl-food fa-2x"></i></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
             <!-- Itens da navegação -->
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="index.php">Início</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="administradores.php">Admin</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="categorias.php">Categorias</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="cardapios.php">Cardápios</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="pedidos.php">Pedidos</a>
              </li>
              <?php
              if(isset($_GET['sair'])) //Se o botão de sair for pressionado
              {
                  unset($_SESSION['usuario']); //Fechar a session
                  session_destroy(); //Destruir a session
                  header("Location: login.php"); //Redirecionar para a página de login
                  exit(0);
              }
              ?>
              <li class="nav-item">
                <a class="nav-link" href="index.php?sair=true">Sair</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>