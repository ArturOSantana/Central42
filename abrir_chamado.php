<?php include "cabecalho_logado.php";
include "con.php";
include "classes/Categoria.php";
$categoria = new Categoria();

?>



<main class="container">
  <section class="row">
    <article class="card-abrir-chamado">
      <div class="card">
        <header class="card-header">
          <h2 class="h5 mb-0">Abertura de Chamado</h2>
        </header>
        <div class="card-body">
          <form action="registra_chamado.php" method="post">


            <div class="form-group">
              <label for="titulo">Título</label>
              <input id="titulo" name="titulo" type="text" class="form-control" placeholder="Título" required>
            </div>



            <div class="form-group">
              <label for="categoria">Categoria</label>
              <select id="categoria" name="id_categoria" class="form-control" required>
                <option value="">SELECIONE UMA CATEGORIA</option>
                <?php
                $opçoes = $categoria->exibirCategorias($con);
                foreach ($opçoes as $cat) {
                  echo "<option value='".$cat['id_categoria'] . "'>"
                    . $cat['nome_categoria'] . " — (" . $cat['nome_departamento'] . ")"
                    . "</option>";
                }
                ?>
              </select>
            </div>

            <div class="form-group">
              <label for="descricao">Descrição</label>
              <textarea id="descricao" name="descricao" class="form-control" rows="3" required></textarea>
            </div>


            <div class="row mt-5">
              <div class="col-6">
                <a href="home.php" class="btn btn-lg btn-warning btn-block btn-voltar">Voltar</a>
              </div>
              <div class="col-6">
                <button class="btn btn-lg btn-info btn-block btn-abrir" type="submit">Abrir</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </article>
  </section>
</main>

<!-- Rodapé -->
<footer class="text-center mt-4 mb-3 text-muted">
  <small>&copy; <?php echo date("Y"); ?> Help Desk</small>
</footer>

</body>

</html>