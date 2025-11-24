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
            <p><strong>Para o Departamento</strong> <?php  echo $chamado['nome_departamento']; ?></p>
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
                <?php echo  $_SESSION['depName'];?>
            </p>
            

            <?php if (($_SESSION['id_tipo_usuario'] == 2 || $_SESSION['id_tipo_usuario'] == 3) && $chamado['status'] == 'Aberto') { ?>
                <form action="fechar_chamado.php" method="get" class="mt-3">
                    <input type="hidden" name="id_chamado" value="<?php echo $id_chamado; ?>">
                    <button type="submit" class="btn btn-danger">Fechar Chamado</button>
                </form>
            <?php } ?>

            <?php if ($chamado['status'] == 'Fechado') { ?>
               <div class="wrap">
	<div class="stars">
		<label class="rate">
			<input type="radio" name="radio1" id="star1" value="star1">
			<div class="face"></div>
			<i class="far fa-star star one-star"></i>
		</label>
		<label class="rate">
			<input type="radio" name="radio1" id="star2" value="star2">
			<div class="face"></div>
			<i class="far fa-star star two-star"></i>
		</label>
		<label class="rate">
			<input type="radio" name="radio1" id="star3" value="star3">
			<div class="face"></div>
			<i class="far fa-star star three-star"></i>
		</label>
		<label class="rate">
			<input type="radio" name="radio1" id="star4" value="star4">
			<div class="face"></div>
			<i class="far fa-star star four-star"></i>
		</label>
		<label class="rate">
			<input type="radio" name="radio1" id="star5" value="star5">
			<div class="face"></div>
			<i class="far fa-star star five-star"></i>
		</label>
	</div>
	</div>
            <?php } ?>

            <div class="mt-4">
                <a href="consultar_chamado.php" class="btn btn-outline-secondary">Voltar</a>
            </div>

        </div>
    </div>
</main>

<?php include "rodape.php"; ?>
