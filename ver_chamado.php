<?php
include "cabecalho_logado.php";
include "conn.php";
include "classes/Chamado.php";
include "classes/Feedback.php";

$id_chamado = $_GET['id'];

$chamados = new Chamado();
$chamado = $chamados->visualizarChamado($con, $id_chamado);
$avaliacao = new Feedback("", "", "", "");
$avaliou = $avaliacao->vericarFeedback($con, $chamado["id_chamado"])
?>

<main class="container-fluid px-4 py-4">
    <div class="card shadow-lg">
        <div class="card-header bg-info text-white py-3">
            <h3 class="mb-0 fw-bold">Detalhes do Chamado #<?php echo $id_chamado; ?></h3>
        </div>
        <div class="card-body p-4">

            <div class="row mb-4">
                <div class="col-12">
                    <p class="mb-2"><strong class="fs-5">Título:</strong> <span class="fs-5"><?php echo $chamado['titulo']; ?></span></p>
                    <p class="mb-0"><strong class="fs-5">Para o Departamento:</strong> <span class="fs-5"><?php echo $chamado['nome_departamento']; ?></span></p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <p class="fw-semibold fs-5 mb-2">Descrição:</p>
                    <div class="border rounded p-3 bg-light">
                        <?php echo ($chamado['descricao']); ?>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <p class="mb-2"><strong>Status:</strong>
                        <?php if ($chamado['status'] == 'Aberto') { ?>
                            <span class="badge bg-success fs-6"><?php echo $chamado['status']; ?></span>
                        <?php } else { ?>
                            <span class="badge bg-danger fs-6"><?php echo $chamado['status']; ?></span>
                        <?php } ?>
                    </p>
                </div>

                <div class="col-md-6 text-md-end">
                    <p class="mb-2"><strong>Data de Abertura:</strong> <?php echo $chamado['data_abertura']; ?></p>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <p class="mb-0"><strong>Usuário:</strong> <?php echo $chamado['nome_usuario']; ?> - <strong>Departamento:</strong>
                        <?php echo $_SESSION['depName']; ?>
                    </p>
                </div>
            </div>

            <?php if (($_SESSION['id_tipo_usuario'] == 2 || $_SESSION['id_tipo_usuario'] == 3) && $chamado['status'] == 'Aberto') { ?>
                <div class="row mt-4">
                    <div class="col-12">
                        <form action="fechar_chamado.php" method="get">
                            <input type="hidden" name="id_chamado" value="<?php echo $id_chamado; ?>">
                            <button type="submit" class="btn btn-danger btn-lg px-4">Fechar Chamado</button>
                        </form>
                    </div>
                </div>
            <?php } ?>

            <div class="row mt-4">
                <div class="col-12">
                    <?php include "avaliar_chamado.php"; ?>
                    <!-- FORMULÁRIO DE COMENTÁRIO -->
                    <div class="mt-4 p-3 border rounded bg-light">
                        <h6 class="mb-3">💬 Adicionar Comentário</h6>
                        <form action="adicionar_comentario.php" method="POST">
                            <input type="hidden" name="id_chamado" value="123"> <!-- ID será preenchido via PHP depois -->

                            <div class="mb-3">
                                <textarea class="form-control" name="comentario" rows="3"
                                    placeholder="Digite seu comentário..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm">
                                📤 Enviar Comentário
                            </button>
                        </form>
                    </div>

                    <!-- LISTA DE COMENTÁRIOS (EXEMPLO ESTÁTICO) -->
                    <div class="mt-4">
                        <h6>💬 Comentários (2)</h6>

                        <!-- Comentário 1 -->
                        <div class="card mb-2">
                            <div class="card-body py-2">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>João Silva</strong>
                                        <small class="text-muted">- TI</small>
                                    </div>
                                    <small class="text-muted">20/11/2025 14:30</small>
                                </div>
                                <p class="mb-0 mt-1">Vou verificar esse problema ainda hoje.</p>
                            </div>
                        </div>

                        <!-- Comentário 2 -->
                        <div class="card mb-2">
                            <div class="card-body py-2">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>Maria Santos</strong>
                                        <small class="text-muted">- RH</small>
                                    </div>
                                    <small class="text-muted">20/11/2025 15:45</small>
                                </div>
                                <p class="mb-0 mt-1">Problema resolvido! Pode fechar o chamado.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include "rodape.php"; ?>