<?php include "cabecalho.php"; ?>


<main class="container">
  <section class="row">
    <article class="card-login">
      <div class="card">
        <header class="card-header">
          <h2 class="h5 mb-0">Cadastro de Usuário</h2>
        </header>

        <div class="card-body">
          <form action="processa_cadastro.php" method="POST">

            <div class="form-group mb-3">
              <input type="text" name="nome" class="form-control" placeholder="Nome completo" required>
            </div>

            <div class="form-group mb-3">
              <input type="email" name="email" class="form-control" placeholder="E-mail" required>
            </div>

            <div class="form-group mb-3">
              <input type="password" name="senha" class="form-control" placeholder="Senha" required>
            </div>

            <div class="form-group mb-3">
              <input type="password" name="confirmar_senha" class="form-control" placeholder="Confirmar senha" required>
            </div>

            <div class="form-group mb-3">
              <select name="id_tipo_usuario" class="form-control" required>
                <option value="">Selecione o tipo de usuário</option>
                <option value="1">Usuário</option>
                <option value="2">Admin</option>
                <option value="3">SuperAdmin</option>
              </select>
            </div>

            <div class="form-group mb-4">
              <select name="id_departamento" class="form-control">
                <option value="">Selecione o departamento</option>
                <option value="1">TI</option>
                <option value="2">RH</option>
                <option value="3">Financeiro</option>
              </select>
            </div>

            <button class="btn btn-lg btn-info btn-block btn-login" type="submit">Cadastrar</button>
            <a href="home.php" class="btn btn-outline-warning w-100 mt-2">Voltar</a>
            

          <br>
        </div>
      </div>
    </article>
  </section>
</main>

<?php include "rodape.php"; ?>
