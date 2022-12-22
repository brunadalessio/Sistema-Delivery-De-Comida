
<?php
//Incluir o header sem navegação para página de login
include('includes/header-login.php'); 
?>

<div class="container">
<!-- Incluir o alerta de mensagens -->
<?php include('includes/alerta.php'); ?>
    <div class="row justify-content-center mt-5">
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card shadow">
          <div class="card-title text-center bg-dark text-white">
            <h4 class="p-3">Entrar como administrador</h4>
          </div>
          <div class="card-body">
             <!-- Formulário de Login -->
            <form action="login.php" method="POST">
              <div class="mb-4">
                <label class="mb-2" for="username">Usuário</label>
                <input type="text" class="form-control" name="usuario"/>
              </div>
              <div class="mb-4">
                <label class="mb-2" for="password">Senha</label>
                <input type="password" class="form-control" name="senha"/>
              </div>
              <hr>
              <div class="d-grid">
                <button type="submit" name="entrar" class="btn btn-primary">Entrar</button>
              </div>
            </form>
            <!-- Final do formulário -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php


if(isset($_POST['entrar'])) //Quando clicar no botão de entrar
{
  $usuario = mysqli_real_escape_string($con, $_POST['usuario']);
  $senha = mysqli_real_escape_string($con, md5($_POST['senha']));


  $q = "SELECT * FROM administrador WHERE usuario='$usuario' AND senha='$senha'"; //Verificar se o usuario e a senha são compativeis


  $qr = mysqli_query($con, $q); //Executar a query
  
  if(mysqli_num_rows($qr) > 0) //Se existir o administrador, deixa logar e guardar o login na sessão de usuario do sistema
  {
    $_SESSION['sucesso'] = "Logado com sucesso.";
    $_SESSION['usuario'] = $usuario;
    header("Location: index.php");
    exit(0);
  }
  else //Senão, mostre mensagem de erro
  {
    $_SESSION['falha'] = "Usuário/Senha incorreta.";
    header("Location: login.php");
    exit(0);
  }

}

?>


<?php 
//Importar footer principal do front-end
include('includes/footer.php'); 
?>
