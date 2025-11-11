<?php
include "cabecalho_logado.php";
include "con.php";
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
          try {
            // Usuário logado
            $user_id = $_SESSION['id'];
            $dep_id = $_SESSION['id_departamento'];
            $perfil_id = $_SESSION['perfil_id'];

            // FILTRO PARA DEFINIR O QUE CADA UM VAI PODER OLHAR 
            if ($perfil_id == 3) {
              // Admin ou super admin vê tudo
              $stmt = $con->prepare("SELECT c.*, u.nome AS usuario_nome, d.nome AS departamento_nome
                               FROM chamados c
                               JOIN usuarios u ON c.id_usuario = u.id_usuario
                               JOIN departamentos d ON c.id_departamento = d.id_departamento
                               ORDER BY c.id_chamado DESC");
            } elseif ($perfil_id == 2) {
              /// CHAMADOS POR DEPARTAMENTO
              $stmt = $con->prepare("SELECT c.*, u.nome AS usuario_nome, d.nome AS departamento_nome
                               FROM chamados c
                               JOIN usuarios u ON c.id_usuario = u.id_usuario
                               JOIN departamentos d ON c.id_departamento = d.id_departamento
                               WHERE c.id_departamento = :dep
                               ORDER BY c.id_chamado DESC");
              $stmt->bindParam(':dep', $dep_id);
            } else {
              // VER APENAS OS SEUS CHAMADOS
              $stmt = $con->prepare("SELECT c.*, u.nome AS usuario_nome, d.nome AS departamento_nome
                               FROM chamados c
                               JOIN usuarios u ON c.id_usuario = u.id_usuario
                               JOIN departamentos d ON c.id_departamento = d.id_departamento
                               WHERE c.id_usuario = :user
                               ORDER BY c.id_chamado DESC");
              $stmt->bindParam(':user', $user_id);
            }

            $stmt->execute();
            $chamados = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                      <span class="<?php echo ($chamado['status'] == 'Aberto') ? 'text-success' : 'text-danger'; ?>">
                        <?php echo ($chamado['status']); ?>
                      </span>
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
          } catch (PDOException $e) {
            echo "Erro ao carregar chamados: " . ($e->getMessage());
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