<?php
include "cabecalho_logado.php";
include "con.php";
include "classes/Usuario.php";

if ($_SESSION['id_tipo_usuario'] != 3) {
    header("location:home.php");
   ;
}

$usuarioModelo = new Usuario("", "", "", "", "");
$mensagem = "";
$tipo_mensagem = "";

if (isset($_GET['excluir'])) { 
    $id_excluir = $_GET['excluir'];

  
        $usuarioModelo->excluirUsuario($con, $id_excluir, $_SESSION['id']);
        $mensagem = "Usuário excluído com sucesso!";
        $tipo_mensagem = "success";
   
}


    $usuarios = $usuarioModelo->listarTodos($con);

?>

<main class="management-container">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Gestão de Usuários</h1>
            <p class="page-subtitle">Administre os usuários do sistema Help Desk</p>
        </div>
        <?php if (!empty($mensagem)){ ?>
            <div class="alert alert-<?php echo $tipo_mensagem; ?>">
                <?php echo $mensagem; ?>
            </div>
        <?php } ?>

        <div class="actions-container">
            <a href="cadastro.php" class="btn btn-success">
                <i class="fas fa-plus"></i> Novo Usuário
            </a>
            <a href="home.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar para Home
            </a>
        </div>

        <div class="table-container">
            <?php if (count($usuarios) > 0){ ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Usuário</th>
                                <th>Email</th>
                                <th>Perfil</th>
                                <th>Departamento</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $user){ ?>
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                <?php echo strtoupper(substr($user['nome'], 0, 2)); ?>
                                            </div>
                                            <div class="user-details">
                                                <h6><?php echo ($user['nome']); ?></h6>
                                                <small>ID: <?php echo $user['id_usuario']; ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo ($user['email']); ?></td>
                                    <td>
                                        <?php 
                                            $badge_class = '';
                                            $perfil = '';
                                            switch ($user['id_tipo_usuario']) {
                                                case 3:
                                                    $badge_class = 'badge-admin';
                                                    $perfil = 'Administrador';
                                                    break;
                                                case 2:
                                                    $badge_class = 'badge-manager';
                                                    $perfil = 'Gestor';
                                                    break;
                                                case 1:
                                                default:
                                                    $badge_class = 'badge-user';
                                                    $perfil = 'Usuário';
                                                    break;
                                            }
                                        ?>
                                        <span class="badge <?php echo $badge_class; ?>">
                                            <?php echo $perfil; ?>
                                        </span>
                                    </td>
                                    <td><?php echo 
                                    ($user['departamento_nome'] ?? 'N/A'); ?></td>
                                    <td>
                                        <span class="status-active">Ativo</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="editar_usuario.php?id=<?php echo $user['id_usuario']; ?>" class="btn-action btn-edit">
                                                Editar
                                            </a>
                                            <a href="gerenciar_usuarios.php?excluir=<?php echo $user['id_usuario']; ?>" 
                                               class="btn-action btn-delete"
                                               onclick="return confirm('Tem certeza que deseja excluir o usuário <?php echo htmlspecialchars($user['nome']); ?>?')">
                                                Excluir
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php }; ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="empty-state">
                    <div class="empty-icon"></div>
                    <h4>Nenhum usuário encontrado</h4>
                    <p>Não há usuários cadastrados no sistema.</p>
                    <a href="cadastro.php" class="btn btn-primary mt-3">
                        Cadastrar Primeiro Usuário
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</main>

<?php include "rodape.php"; ?>