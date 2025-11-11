<?php include "cabecalho.php"; ?>

<main class="container">
  <section class="row">
    <article class="card-login">
      <div class="card">
        <header class="card-header">
          <h2 class="h5 mb-0">Login</h2>
        </header>
        <div class="card-body">
          <form action="valida_login.php" method="post">
            <div class="form-group">
              <input name="email" type="email" class="form-control" placeholder="E-mail" required>
            </div>
            <div class="form-group">
              <input name="senha" type="password" class="form-control" placeholder="Senha" required>
            </div>

            <?php if (isset($_GET['login']) && $_GET['login'] == 'erro') { ?>
              <p class="error-message">Usuário ou senha inválido(s)</p>
            <?php } ?>

            <?php if (isset($_GET['login']) && $_GET['login'] == 'erro2') { ?>
              <p class="error-message">Por favor, faça login antes de acessar as páginas protegidas</p>
            <?php } ?>


            <button class="btn btn-lg btn-info btn-block btn-login" type="submit">Entrar</button>
          </form>
          <br>
       
        </div>
      </div>
    </article>
  </section>
</main>

<?php include "rodape.php"; ?>