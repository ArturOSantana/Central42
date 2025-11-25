<?php
include "cabecalho_logado.php";
include "conn.php";

include "classes/Departamento.php";
$depar = new Departamento();
?>

<main class="container-fluid px-4 py-4">
  <section class="row justify-content-center">
    <article class="col-12 col-xl-10">
      <div class="card shadow-lg">
        <header class="card-header bg-info text-white py-3">
          <h2 class="h4 mb-0 fw-bold">Abertura de Chamado</h2>
        </header>
        <div class="card-body p-4">
          <form action="registra_chamado.php" method="post">

            <div class="row">
              <div class="col-12 mb-4">
                <label for="titulo" class="form-label fw-semibold">Assunto</label>
                <input id="titulo" name="titulo" type="text" class="form-control form-control-lg"
                  placeholder="Ex: Problema com email, Solicitação de férias..." required>
              </div>
            </div>

            <div class="row">
              <div class="col-12 mb-4">
                <label for="departamento_destino" class="form-label fw-semibold">Departamento Destino</label>
                <select id="departamento_destino" name="departamento_destino" class="form-select form-select-lg" required>
                  <option value="">SELECIONE O DEPARTAMENTO DESTINO</option>
                  <?php
                  $departamentos = $depar->mostrarDep($con);

                  foreach ($departamentos as $depto) {
                    echo "<option value='{$depto['id_departamento']}'>{$depto['nome']}</option>";
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-12 mb-4">
                <label for="descricao" class="form-label fw-semibold">Descrição Detalhada</label>
                <textarea id="descricao" name="descricao" class="form-control" rows="6"
                  placeholder="Descreva detalhadamente o seu problema ou solicitação..." required></textarea>
              </div>
            </div>

            <div class="row mt-4">
              <div class="col-12 col-md-6 mb-2">
                <a href="home.php" class="btn btn-lg btn-warning btn-block w-100 py-2">Voltar</a>
              </div>
              <div class="col-12 col-md-6 mb-2">
                <button class="btn btn-lg btn-info btn-block w-100 py-2" type="submit">Abrir Chamado</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </article>
  </section>
</main>

<?php include "rodape.php"; ?>