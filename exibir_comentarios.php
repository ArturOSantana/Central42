<?php if ($chamado["status"] == "Aberto"){ ?>
    <div class="mt-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-3">
                <h6 class="mb-0 fw-bold"><i class="fas fa-comment me-2"></i>Adicionar Comentário</h6>
            </div>
            <div class="card-body">
                <form action="registrar_comentario.php" method="POST">
                    <input type="hidden" name="id_chamado" value="<?php echo $id_chamado; ?>">

                    <div class="mb-3">
                        <textarea class="form-control" name="comentario" rows="4"
                            placeholder="Digite seu comentário aqui..." required></textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-paper-plane me-2"></i>Enviar Comentário
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

<div class="mt-5">
    <div class="d-flex align-items-center mb-4">
        <h5 class="mb-0 fw-bold text-dark">
            <i class="fas fa-comments me-2"></i>Comentários <?php echo count($comentarios); ?>
        </h5>
        <br>

    </div>

    <?php if (empty($comentarios)){ ?>
        <div class="text-center py-5">
            <i class="fas fa-comment-slash text-muted fa-3x mb-3"></i>
            <p class="text-muted mb-0">Nenhum comentário ainda.</p>
        </div>
    <?php } else { ?>
        <div class="row g-3">
            <?php foreach ($comentarios as $comment){ ?>
                <div class="col-12">
                    <div class="card border-0 shadow-sm h-90">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h6 class="mb-1 fw-bold text-dark"><?php echo $comment['nome']; ?></h6>
                                        <small class="text-muted">
                                            <i class="fas fa-building me-1"></i>
                                            <?php echo $comment['nome_departamento']; ?>
                                        </small>
                                    </div>
                                </div>
                                <small class="text-muted">
                                    <i class="far fa-clock me-1"></i>
                                    <?php echo ($comment["data_comentario"]); ?>
                                </small>
                            </div>

                            <div class="border-start border-3 border-primary ps-3">
                                <p class="mb-0 text-dark lh-base"><?php echo $comment["comentario"]; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }; ?>
        </div>
    <?php } ?>
</div>