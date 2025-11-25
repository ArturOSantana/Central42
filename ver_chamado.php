<?php
include "cabecalho_logado.php";
include "conn.php";
include "classes/Chamado.php";

$id_chamado = $_GET['id'];

$chamados = new Chamado();
$chamado = $chamados->visualizarChamado($con, $id_chamado);

?>

<main class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h3 class="mb-0">Detalhes do Chamado #<?php echo $id_chamado; ?></h3>
        </div>
        <div class="card-body">

            <p><strong>Título:</strong> <?php echo $chamado['titulo']; ?></p>
            <p><strong>Para o Departamento</strong> <?php echo $chamado['nome_departamento']; ?></p>
            <p><strong>Descrição:</strong></p>
            <p class="border rounded p-2 bg-light"><?php echo $chamado['descricao']; ?></p>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Status:</strong>
                        <?php if ($chamado['status'] == 'Aberto') { ?>
                            <span class="text-success"><?php echo $chamado['status']; ?></span>
                        <?php } else { ?>
                            <span class="text-danger"><?php echo $chamado['status']; ?></span>
                        <?php } ?>
                    </p>
                </div>

                <div class="col-md-6 text-md-end">
                    <p><strong>Data de Abertura:</strong> <?php echo $chamado['data_abertura']; ?></p>
                </div>
            </div>

            <p><strong>Usuário:</strong> <?php echo $chamado['nome_usuario']; ?> - <strong>Departamento:</strong>
                <?php echo  $_SESSION['depName']; ?>
            </p>


            <?php if (($_SESSION['id_tipo_usuario'] == 2 || $_SESSION['id_tipo_usuario'] == 3) && $chamado['status'] == 'Aberto') { ?>
                <form action="fechar_chamado.php" method="get" class="mt-3">
                    <input type="hidden" name="id_chamado" value="<?php echo $id_chamado; ?>">
                    <button type="submit" class="btn btn-danger">Fechar Chamado</button>
                </form>
            <?php } ?>
            <!-- FEEDBACK-->
            <?php if ($chamado['status'] == 'Fechado' && $chamado["id_usuario"] == $_SESSION["id"]) { ?>
                <form action="enviar_feedback.php" method="POST">
                   <!--ENVIA O ID DO CHAMADO PARA O FEEDBACK -->
                    <input type="hidden" name="id_chamado" value="<?php echo $id_chamado; ?>">

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="nota" id="inlineRadio1" value="1" required>
                        <label class="form-check-label" for="inlineRadio1">1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="nota" id="inlineRadio2" value="2" required>
                        <label class="form-check-label" for="inlineRadio2">2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="nota" id="inlineRadio3" value="3" required>
                        <label class="form-check-label" for="inlineRadio3"> 3</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="nota" id="inlineRadio4" value="4" required>
                        <label class="form-check-label" for="inlineRadio4"> 4</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="nota" id="inlineRadio5" value="5" required>
                        <label class="form-check-label" for="inlineRadio5"> 5</label>
                    </div>

                    <div class="form-floating">
                        <textarea class="form-control" placeholder="DEIXE UM COMENTARIO..." id="floatingTextarea" name="comentario"></textarea>

                    </div>

                    <button type="submit" class="btn btn-warning">Enviar Avaliação</button>
                </form>
            <?php } ?>

            <div class="mt-4">
                <a href="consultar_chamado.php" class="btn btn-outline-secondary">Voltar</a>
            </div>

        </div>
    </div>
</main>

<?php include "rodape.php"; ?>