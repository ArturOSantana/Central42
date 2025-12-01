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


if (isset($_GET['excluir'])) {
    $id_excluir = $_GET['excluir'];

    $resultado = $usuarioModelo->excluirUsuario($con, $id_excluir, $_SESSION['id']);
    if ($resultado == true) {
        $mensagem = "Usuário excluído com sucesso!";
        $tipo_mensagem = "success";
    } else {
        $mensagem = "Erro ao excluir usuário!";
        $tipo_mensagem = "danger";
    }
}


$usuarios = $usuarioModelo->listarTodos($con);
?>

<main class="management-container">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="page-title">
                        <i class="fas fa-users-cog me-3"></i>Gestão de Usuários
                    </h1>
                </div>
                <div class="col-md-4 text-end">
                    <div class="user-stats">
                        Total: <?php echo count($usuarios); ?> usuários
                    </div>
                </div>
            </div>
        </div>


        <div class="actions-container">
            <div class="row">
                <div class="col-md-6">
                    <a href="cadastro.php" class="btn btn-success btn-lg">
                        <i class="fas fa-user-plus me-2"></i>Novo Usuário
                    </a>
                    <a href="home.php" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-home me-2"></i>Voltar para Home
                    </a>
                </div>
                <div class="col-md-6 text-end">
                    <div class="input-group search-box">
                        <input type="text" class="form-control" placeholder="Buscar usuário..." id="searchInput">
                        <button class="btn btn-outline-primary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="users-table-container">
            <?php if (count($usuarios) > 1){ ?>
                <div class="table-responsive">
                    <table class="table table-hover" id="usersTable">
                        <thead class="table-dark">
                            <tr>
                                <th width="25%">Usuário</th>
                                <th width="20%">Email</th>
                                <th width="15%">Perfil</th>
                                <th width="15%">Departamento</th>
                                <th width="15%" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $user){?>
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                <?php echo strtoupper(substr($user['nome'], 0, 2)); ?>
                                            </div>
                                            <div class="user-details">
                                                <h6 class="mb-1">
                                                    <?php echo $user['nome']; ?>
                                                </h6>
                                                <small class="text-muted">ID: <?php echo $user['id_usuario']; ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="email-cell">
                                            <i class="fas fa-envelope me-2 text-muted"></i>
                                            <?php echo $user['email']; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php

                                        $perfil = '';

                                        switch ($user['id_tipo_usuario']) {
                                            case 3:
                                                $perfil = 'Administrador';
                                                break;
                                            case 2:
                                                $perfil = 'Gestor';
                                                break;
                                            case 1:
                                            default:
                                                $perfil = 'Usuário';
                                                break;
                                        }
                                        ?>
                                        <span class="badge badge-pill badge-primary">
                                            <?php echo $perfil; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="department-cell">
                                            <i class="fas fa-building me-2 text-muted"></i>
                                            <?php echo $user['departamento_nome']; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-grid gap-2 d-md-block">
                                            <a href="editar_usuario.php?id=<?php echo $user['id_usuario']; ?>"
                                                class="btn-action btn-edit"
                                                title="Editar usuário">
                                                <p>EDITAR</p>
                                            </a>

                                            <?php if ($user['id_usuario'] != $_SESSION['id']){ ?>
                                                <a href="gerenciar_usuarios.php?excluir=<?php echo $user['id_usuario']; ?>"
                                                    class="btn btn-outline-danger"
                                                    title="Excluir usuário"
                                                    onclick="return confirm('Tem certeza que deseja excluir o usuário <?php echo $user['nome']; ?>? Esta ação não pode ser desfeita.')"> 
                                                    <p>EXCLUIR</p>
                                                </a>
                                            <?php } else { ?>
                                                <span class="btn-action btn-hidded" title="Não é possível excluir sua própria conta">
                                                    <p>EXCLUIR</p>
                                                </span>
                                            <?php }; ?>

                                        </div>
                                    </td>
                                </tr>
                            <?php }; ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-users fa-5x"></i>
                    </div>
                    <h3>Nenhum usuário encontrado</h3>
                    <p class="mb-4">Não há usuários cadastrados no sistema no momento.</p>
                    <a href="cadastro.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-user-plus me-2"></i>Cadastrar Primeiro Usuário
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</main>

<script>
    // Busca em tempo real
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const rows = document.querySelectorAll('#usersTable tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchText) ? '' : 'none';
        });
    });
</script>

<?php include "rodape.php"; ?>