<?php
include "cabecalho_logado.php";
include "con.php";
include "classes/Chamado.php";

$chamado = new Chamado("", "", "", "", "");
?>
<main class="container mt-4">
  <section class="row">
    <article class="card-consultar-chamado">
      <div class="card shadow-sm border-0">
        <header class="card-header bg-primary text-white">
          <h2 class="h5 mb-0">Consulta de Chamados</h2>
        </header>

        <div class="card-body">

          <?php

          // Usuário logado
          $user_id = $_SESSION['id'];
          $dep_id = $_SESSION['id_departamento'];
          $perfil_id = $_SESSION['perfil_id'];


          if ($perfil_id == 3) {
            $chamados = $chamado->listarTodos($con);
          } elseif ($perfil_id == 2) {
            /// CHAMADOS POR DEPARTAMENTO
            $chamados = $chamado->listarPorDepartamento($con, $dep_id);
          } else {
            // VER APENAS OS SEUS CHAMADOS
            $chamados = $chamado->listarPorUsuario($con, $user_id);
          }

          if (count($chamados) === 0) {
            echo '<p class="text-muted text-center mt-3">Nenhum chamado encontrado.</p>';
          } else {
            foreach ($chamados as $chamado) {
          ?>
              <div class="card mb-3 shadow-sm chamado-card">
                <div class="card-body">
                  <h5 class="card-title text-primary"><?php echo ($chamado['titulo']); ?></h5>
                  <h6 class="card-subtitle mb-2 text-muted">
                    Categoria: <?php echo ($chamado['categoria']); ?> |
                    Status:
                    <?php if ($chamado['status'] == 'Aberto') { ?>
                      <span class="text-success">
                        <?php echo $chamado['status']; ?>
                      </span>
                    <?php } else { ?>
                      <span class="text-danger">
                        <?php echo $chamado['status']; ?>
                      </span>
                    <?php } ?>
                  </h6>
                  <p class="card-text"><?php echo ($chamado['descricao']); ?></p>

                  <small class="text-muted">
                    Aberto por <?php echo ($chamado['usuario_nome']); ?> —
                    Departamento: <?php echo ($chamado['departamento_nome']); ?> —
                    em <?php echo ($chamado['data_abertura']); ?>
                  </small>

                </div>
                <a href="ver_chamado.php?id=<?php echo $chamado['id_chamado']; ?>"
                  class="btn btn-sm btn-outline-primary mt-2">
                  Ver Detalhes
                </a>
              </div>
          <?php
            }
          }
          ?>

          <div class="row mt-5">
            <div class="col-6">
              <a href="home.php" class="btn btn-lg btn-warning btn-block btn-voltar">Voltar</a>
            </div>
          </div>

        </div>
      </div>
    </article>
  </section>
</main>

<?php include "rodape.php"; ?>