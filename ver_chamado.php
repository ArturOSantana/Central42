<?php
include "cabecalho_logado.php";
include "conn.php";
include "classes/Chamado.php";
include "classes/Feedback.php";
include "classes/Comentarios.php";

$id_chamado = $_GET['id'];

$chamados = new Chamado();
$chamado = $chamados->visualizarChamado($con, $id_chamado);
 $modelo = new Comentarios("", "", "");
 $comentarios = $modelo->mostrarComentarios($con,$id_chamado);
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

            <!-- REABIR CHAMADO --> 
             <?php if (($_SESSION['id_tipo_usuario'] == 2 || $_SESSION['id_tipo_usuario'] == 3) && $chamado['status'] == 'Fechado') { ?>
                <div class="row mt-4">
                    <div class="col-12">
                        <form action="ver_chamado.php?id=<?php echo $chamado['id_chamado'] ?>>
                            <input type="hidden" name="id_chamado" value="<?php echo $id_chamado; ?>">
                            <button type="submit" class="btn btn-danger btn-lg px-4">Reabir Chamado</button>
                            <?php $chamado ->reabrirChamado($con) ?>
                        </form>
                    </div>
                </div>
            <?php } ?>

            <div class="row mt-4">
                <div class="col-12">
                    <?php include "avaliar_chamado.php"; ?>
                </div>
                   <?php include "exibir_comentarios.php"; ?>
                   
                
            </div>
        </div>
    </div>
</main>

<?php include "rodape.php"; ?>