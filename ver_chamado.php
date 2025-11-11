<?php
include "cabecalho_logado.php";
include "con.php";
session_start();




$id_chamado = $_GET['id'];

// Aqui depois você colocará o PDO para buscar no banco
// Exemplo de consulta (apenas referência):
$stmt = $con->prepare(" SELECT 
        c.*, 
        u.nome AS nome_usuario,
        u.email,
        d.nome AS nome_departamento
    FROM chamados AS c
    INNER JOIN usuarios AS u ON u.id_usuario = c.id_usuario
    INNER JOIN departamentos AS d ON d.id_departamento = c.id_departamento
    WHERE c.id_chamado = :id");
$stmt->bindParam(":id", $id_chamado);
$stmt->execute();
$chamado = $stmt->fetch(PDO::FETCH_ASSOC);

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

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Status:</strong>
                    <?php
                    if ($chamado['status'] == 'Fechado'){ ?>
                       <span class="badge bg-secondary">
                            <?php echo ($chamado['status']);} else { 
                               echo '<span class="badge bg-secondary">';
                             echo ($chamado['status']);
                            } ?>
                        </span>
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p><strong>Data de Abertura:</strong>
                        <?php echo ($chamado['data_abertura']); ?>
                    </p>
                </div>
            </div>

            <p><strong>Usuário:</strong> <?php echo $chamado['nome_usuario']; ?></p>
            <p><strong>Departamento:</strong> <?php echo $chamado['nome_departamento']; ?></p>
            <?php if ($_SESSION['id_tipo_usuario'] == 2 || $_SESSION['id_tipo_usuario'] == 3 && $chamado['status'] == 'Aberto') { ?>
                <form action="fechar_chamado.php" method="POST" class="mt-3">
                    <input type="hidden" name="id_chamado" value="<?php echo $id_chamado; ?>">
                    <button type="submit" class="btn btn-danger">Fechar Chamado</button>
                </form>
            <?php } ?>



            <div class="mt-4">
                <a href="consultar_chamado.php" class="btn btn-outline-secondary">Voltar</a>
            </div>

        </div>
    </div>
</main>

<?php include "rodape.php"; ?>