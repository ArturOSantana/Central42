<?php
include "cabecalho_logado.php";
include "con.php";
include "classes/Chamado.php";

$chamado_obj = new Chamado("", "", "", "");

// DEBUG
echo "<!-- DEBUG: User: {$_SESSION['nome']}, Depto: {$_SESSION['id_departamento']}, Perfil: {$_SESSION['id_tipo_usuario']} -->";

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
          // Usar id_tipo_usuario em vez de perfil_id
          $user_id = $_SESSION['id'];
          $dep_id = $_SESSION['id_departamento'];
          $perfil_id = $_SESSION['id_tipo_usuario']; // ✅ CORREÇÃO AQUI

          echo "<!-- DEBUG: Perfil detectado: $perfil_id -->";

          if ($perfil_id == 3) {
            // ADMIN - ver todos
            $chamados = $chamado_obj->listarTodos($con);
            echo "<!-- DEBUG: Modo ADMIN - Todos os chamados -->";
          } elseif ($perfil_id == 2) {
            // SUPERVISOR - ver chamados do SEU departamento (como destino)
            $chamados = $chamado_obj->listarPorDepartamento($con, $dep_id);
            echo "<!-- DEBUG: Modo SUPERVISOR - Chamados com destino ao departamento $dep_id -->";
            echo "<!-- DEBUG: Chamados encontrados: " . count($chamados) . " -->";
          } else {
            // USUÁRIO COMUM - ver apenas seus próprios chamados
            $chamados = $chamado_obj->listarPorUsuario($con, $user_id);
            echo "<!-- DEBUG: Modo USUÁRIO - Apenas meus chamados -->";
          }

          if (count($chamados) === 0) {
            echo '<p class="text-muted text-center mt-3">Nenhum chamado encontrado.</p>';
          } else {
            foreach ($chamados as $chamado) {
          ?>
              <div class="card mb-3 shadow-sm chamado-card">
                <div class="card-body">
                  <h5 class="card-title text-primary"><?php echo htmlspecialchars($chamado['titulo']); ?></h5>
                  <h6 class="card-subtitle mb-2 text-muted">
                    Status:
                    <?php if ($chamado['status'] == 'Aberto') { ?>
                      <span class="text-success"><?php echo $chamado['status']; ?></span>
                    <?php } else { ?>
                      <span class="text-danger"><?php echo $chamado['status']; ?></span>
                    <?php } ?>
                  </h6>
                  <p class="card-text"><?php echo htmlspecialchars($chamado['descricao']); ?></p>

                  <small class="text-muted">
                    Aberto por <?php echo htmlspecialchars($chamado['usuario_nome']); ?> —
                    Departamento: <?php echo htmlspecialchars($chamado['departamento_nome']); ?> —
                    em <?php echo htmlspecialchars($chamado['data_abertura']); ?>
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