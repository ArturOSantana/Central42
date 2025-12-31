<?php
include "cabecalho_logado.php";
include "conn.php";
include "classes/Usuario.php";

// Verificação de permissão
if ($_SESSION['id_tipo_usuario'] != 3) {
    header("location: home.php");
    exit;
}

$usuarioModelo = new Usuario("", "", "", "", "");

// Exclusão de usuário
if (isset($_GET['excluir'])) {
    $id_excluir = (int) $_GET['excluir'];
    $usuarioModelo->excluirUsuario($con, $id_excluir, $_SESSION['id']);
}

// Listagem
$usuarios = $usuarioModelo->listarTodos($con);
?>



<main class="management-container">
    <div class="container-fluid">

        <!-- Cabeçalho -->
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="page-title">
                        <i class="fas fa-users-cog me-3"></i> Gestão de Usuários
                    </h1>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge bg-dark fs-6">
                        Total: <?php echo count($usuarios); ?> usuários
                    </span>
                </div>
            </div>
        </div>

        <!-- Ações -->
        <div class="actions-container mb-4">
            <div class="row">
                <div class="col-md-6">
                    <a href="cadastro.php" class="btn btn-success btn-lg me-2">
                        <i class="fas fa-user-plus me-2"></i>Novo Usuário
                    </a>
                    <a href="home.php" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-home me-2"></i>Home
                    </a>
                </div>
                <div class="col-md-6 text-end">
                    <div class="input-group w-75 float-end">
                        <input type="text" class="form-control" placeholder="Buscar usuário" id = "searchInput">
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela -->
        <div class="users-table-container">
            <?php if (count($usuarios) > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="tabelaUsuarios">
                        <thead class="table-dark">
                            <tr>
                                <th>Usuário</th>
                                <th>Email</th>
                                <th>Perfil</th>
                                <th>Departamento</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $user) { ?>

                                <?php
                                $perfil = match ($user['id_tipo_usuario']) {
                                    3 => 'Administrador',
                                    2 => 'Gestor',
                                    default => 'Usuário'
                                };

                                $badgeClass = match ($user['id_tipo_usuario']) {
                                    3 => 'bg-danger',
                                    2 => 'bg-warning text-dark',
                                    default => 'bg-secondary'
                                };
                                ?>

                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center"
                                                 style="width:45px;height:45px;">
                                                <?php echo strtoupper(substr($user['nome'], 0, 2)); ?>
                                            </div>
                                            <div>
                                                <strong><?php echo $user['nome']; ?></strong><br>
                                                <small class="text-muted">ID: <?php echo $user['id_usuario']; ?></small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <i class="fas fa-envelope me-2 text-muted"></i>
                                        <?php echo $user['email']; ?>
                                    </td>

                                    <td>
                                        <span class="badge <?php echo $badgeClass; ?>">
                                            <?php echo $perfil; ?>
                                        </span>
                                    </td>

                                    <td>
                                        <i class="fas fa-building me-2 text-muted"></i>
                                        <?php echo $user['departamento_nome']; ?>
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group" role="group">

                                            <a href="editar_usuario.php?id=<?php echo $user['id_usuario']; ?>"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit me-1"></i> Editar
                                            </a>

                                            <?php if ($user['id_usuario'] != $_SESSION['id']) { ?>
                                                <a href="gerenciar_usuarios.php?excluir=<?php echo $user['id_usuario']; ?>"
                                                   class="btn btn-sm btn-outline-danger"
                                                   onclick="return confirm('Tem certeza que deseja excluir o usuário <?php echo $user['nome']; ?>?')">
                                                    <i class="fas fa-trash me-1"></i> Excluir
                                                </a>
                                            <?php } else { ?>
                                                <button class="btn btn-sm btn-outline-secondary" disabled>
                                                    <i class="fas fa-ban me-1"></i> Excluir
                                                </button>
                                            <?php } ?>

                                        </div>
                                    </td>
                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x mb-3 text-muted"></i>
                    <h4>Nenhum usuário encontrado</h4>
                    <p class="text-muted">Não há usuários cadastrados no sistema.</p>
                    <a href="cadastro.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-user-plus me-2"></i>Cadastrar Usuário
                    </a>
                </div>
            <?php } ?>
        </div>

    </div>
</main>

<?php include "rodape.php"; ?>
<script>
document.getElementById('searchInput').addEventListener('keyup', function () {
    let filtro = this.value.toLowerCase();
    let linhas = document.querySelectorAll('#tabelaUsuarios tbody tr');

    linhas.forEach(function (linha) {
        let textoLinha = linha.innerText.toLowerCase();

        if (textoLinha.includes(filtro)) {
            linha.style.display = '';
        } else {
            linha.style.display = 'none';
        }
    });
});
</script>