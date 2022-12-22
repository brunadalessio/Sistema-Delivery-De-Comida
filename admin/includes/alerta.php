<?php
if(isset($_SESSION['sucesso'])) : //Se a requisição executar, mostre mensagem de sucesso
?>

<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= $_SESSION['sucesso']; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<?php
    unset($_SESSION['sucesso']); //Fechar session
    endif;
?>

<?php
if(isset($_SESSION['falha'])) : //Se a requisição NÃO executar, mostre mensagem de falha
?>

<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= $_SESSION['falha']; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<?php
    unset($_SESSION['falha']); //Fechar session
    endif;
?>