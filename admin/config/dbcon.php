<?php 
// Configuração do banco de dados
$con = mysqli_connect("localhost", "root", "", "projeto_bruna");
// Fuso horário de São Paulo (Para formatação de datas brasileiras)
date_default_timezone_set('America/Sao_Paulo');

//Caso ocorra algum erro na conexão, mostre a mensagem abaixo
if(!$con){
    die('A conexão falhou'. mysqli_connect_error());
}

?>