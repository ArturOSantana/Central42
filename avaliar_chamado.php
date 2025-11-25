
 <?php if ($chamado['status'] == 'Fechado') { ?>

                <?php if ($avaliou == true) { ?>
                     <div class="mt-4 p-3 border rounded bg-light">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Nota: <?php echo $avaliou["nota"]; ?> </p>
                            </div>

                            <div class="col-md-6 text-md-end">
                                <p> Avaliado em: <?php echo $avaliou["data_feedback"]; ?> </p>
                            </div>
                        </div>
                        <p>Comentário: </p>
                        <p class="border rounded p-2 bg-white"> <?php if (empty($avaliou["comentario"])) {
                                                                    echo "O USUARIO NÃO ADICIONOU COMENTARIO" . "</p>" ?> 
                                                                <?php } else {
                                                                                                                                                       echo $avaliou["comentario"] . "</p>" ?>
                            <?php }
                                                                                                                        "</p>" ?>
                   
                <?php }  elseif ($chamado["id_usuario"] == $_SESSION["id"]){?>
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

                      
                    <?php } else {?>
                        <div  class="mt-4 p-3 border rounded bg-light>
                        <p class="text-muted mb-0"> Chamado ainda não avaliado </p>
                        </div>
                        <?php }?>
                      <?php } ?>


                        <div class="mt-4">
                            <a href="consultar_chamado.php" class="btn btn-outline-secondary">Voltar</a>
                        </div>

                    </div>