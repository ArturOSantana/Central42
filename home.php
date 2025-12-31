<?php 
include "cabecalho_logado.php";
?>

<main class="container-fluid">
  <div class="row">
    <aside class="col-md-2 col-lg-2 bg-light border-end p-3">
      <div class="text-center mb-4">
        <img src="img/logo.png" alt="Usuário" width="80" class="rounded-circle mb-2">
        <h5 class="mb-0"><?php echo $_SESSION['nome']; ?></h5>
        <small class="text-muted"><?php echo $_SESSION['email']; ?></small>
      </div>

      <ul class="list-group">
        <li class="list-group-item"><strong>Tipo:</strong> <?php echo $_SESSION['tipo']; ?></li>
        <li class="list-group-item"><strong>Departamento:</strong> <?php echo $_SESSION['depName']; ?></li>
      </ul>
      <hr>      
      <?php if($_SESSION['id_tipo_usuario'] == "3"){ ?>
        <a href="gerenciar_usuarios.php" class="btn btn-outline-primary w-100 mb-2">
          Gerenciar Usuários
        </a>
        <a href="cadastro.php" class="btn btn-outline-primary w-100 mb-2">
          Cadastrar Usuario
        </a>
      <?php } ?>
      
      <a href="logoff.php" class="btn btn-outline-danger w-100 mt-2">Sair</a>
    </aside>

    <section class="col-md-10 col-lg-10 p-4">
      <article>
        <div class="card">
          <header class="card-header">
            <h2 class="mb-0">Menu</h2>
          </header>
          <div class="card-body">
            <div class="row text-center">
              <div class="col-md-6 mb-4">
                <a href="abrir_chamado.php">
                  <img src="img/formulario_abrir_chamado.png" alt="Abrir Chamado" class="img-fluid" style="max-width:150px;">
                </a>
                <p class="mt-2">Abrir Chamado</p>
              </div>
              <div class="col-md-6 mb-4">
                <a href="consultar_chamado.php">
                  <img src="img/formulario_consultar_chamado.png" alt="Consultar Chamado" class="img-fluid" style="max-width:150px;">
                </a>
                <p class="mt-2">Consultar Chamado</p>
              </div>
              
              <?php if($_SESSION['id_tipo_usuario'] == "3"){ ?>
                <div class="col-md-6 mb-4">
                  <a href="gerenciar_usuarios.php">
                    <img src="img/gerenciarUsuario.png" alt="Gerenciar Usuários" class="img-fluid" style="max-width:150px;">
                  </a>
                  <p class="mt-4">Gerenciar Usuários</p>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </article>
    </section>
  </div>
</main>

<?php include "rodape.php"; ?>