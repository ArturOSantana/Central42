<?php 
include "cabecalho_logado.php";
include "conn.php";

include "classes/Departamento.php";
$depar = new Departamento();
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
              <label for="titulo">Assunto</label>
              <input id="titulo" name="titulo" type="text" class="form-control" placeholder="Ex: Problema com email, Solicitação de férias..." required>
            </div>

            <div class="form-group">
              <label for="departamento_destino">Departamento Destino</label>
              <select id="departamento_destino" name="departamento_destino" class="form-control" required>
                <option value="">PARA QUAL DEPARTAMENTO?</option>
                <?php
                $departamentos = $depar -> mostrarDep($con);
                
                foreach ($departamentos as $depto) {
                  echo "<option value='{$depto['id_departamento']}'>{$depto['nome']}</option>";
                }
                ?>
              </select>
            </div>

            <div class="form-group">
              <label for="descricao">Descrição Detalhada</label>
              <textarea id="descricao" name="descricao" class="form-control" rows="4" 
                        placeholder="Descreva detalhadamente o seu problema ou solicitação..." required></textarea>
            </div>

            <div class="row mt-5">
              <div class="col-6">
                <a href="home.php" class="btn btn-lg btn-warning btn-block">Voltar</a>
              </div>
              <div class="col-6">
                <button class="btn btn-lg btn-info btn-block" type="submit">Abrir Chamado</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </article>
  </section>
</main>

<?php include "rodape.php"; ?>