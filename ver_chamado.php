<?php
include "cabecalho_logado.php";
include "con.php";
session_start();
include "classes/Chamado.php";




$id_chamado = $_GET['id'];

$chamados = new Chamado();
 $chamado = $chamados -> visualizarChamado($con,$id_chamado);

?>


<main class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h3 class="mb-0">Detalhes do Chamado #<?php echo ($id_chamado); ?></h3>
        </div>
        <div class="card-body">

            <p><strong>Título:</strong> <?php echo $chamado['titulo']; ?></p>
            <p><strong>Categoria:</strong> <?php echo $chamado['categoria']; ?></p>
            <p><strong>Descrição:</strong></p>
            <p class="border rounded p-2 bg-light"><?php echo $chamado['descricao']; ?></p>

            <hr>

            <div class="row"> -
                <div class="col-md-6">
                    <p><strong>Status:</strong>
                       <?php if ($chamado['status'] == 'Aberto') { ?>
                      <span class="text-success">
                        <?php echo $chamado['status']; ?>
                      </span>
                    <?php } else { ?>
                      <span class="text-danger">
                        <?php echo $chamado['status']; ?>
                      </span>
                    <?php } ?>
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p><strong>Data de Abertura:</strong>
                        <?php echo ($chamado['data_abertura']); ?>
                    </p>
                </div>
            </div>

               <div class="col-md-6 text-md-end">
                    <p><strong>AVALIAÇÃO do CHAMADO:</strong>
                        <?php echo ($chamado['data_abertura']); ?>
                    </p>
                </div>

            <p><strong>Usuário:</strong> <?php echo $chamado['nome_usuario']; ?></p>
            <p><strong>Departamento:</strong> <?php echo $chamado['nome_departamento']; ?></p>
            <?php if ($_SESSION['id_tipo_usuario'] == 2 || $_SESSION['id_tipo_usuario'] == 3 && $chamado['status'] == 'Aberto') { ?>
                <form action="fechar_chamado.php?get=$_GET['id_chamado']" method="get" class="mt-3">
                    <input type="hidden" name="id_chamado" value="<?php echo $id_chamado; ?>">
                    <button type="submit" class="btn btn-danger">Fechar Chamado</button>
                </form>
            <?php } ?>
                    </p>
                </div>



            <div class="mt-4">
                <a href="consultar_chamado.php" class="btn btn-outline-secondary">Voltar</a>
            </div>

        </div>
    </div>
</main>

<?php include "rodape.php"; ?>