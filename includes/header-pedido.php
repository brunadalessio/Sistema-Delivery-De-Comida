<?php
// Configuração do banco de dados
session_start();
require 'admin/config/dbcon.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto - Pedido</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Bootstrap CSS Versão 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>

 <!-- Função do JavaScript para chamar API da Geolocalização no carregamento da página -->
<body onload="registrarLocalizacao();">
    <!-- Navbar principal do Pedido -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.php"><i class="fa-solid fa-bowl-food fa-2x"></i></a>
      </nav>