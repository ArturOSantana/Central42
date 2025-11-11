<?php 



$chamado = array();

$arquivo = fopen('chamado.txt', 'r');

while(!feof($arquivo)){
  $registro = fgets($arquivo);
  $chamado[] = $registro;
  $detalhes = explode("#",$registro);

  
}
fclose($arquivo);


 include "cabecalho_logado.php"; 
?>

  <!-- Conteúdo principal -->
  <main class="container">
    <section class="row">
      <article class="card-consultar-chamado">
        <div class="card">
          <header class="card-header">
            <h2 class="h5 mb-0">Consulta de Chamado</h2>
          </header>
          
          <div class="card-body">
            

<?php
foreach($chamado as $chamados){
 
   $consulta_dados = explode("#", $chamados);

  // se a linha do arquivo for inválida, pula
  if(count($consulta_dados) < 3) { 
    continue; 
  }

  if ($_SESSION['perfil_id'] == 2 && $_SESSION['id'] != $consulta_dados[0]) {
    continue;
  }
 


?>

g
            <div class="card chamado-card">
              <div class="card-body">
                <h5 class="card-title"><?php echo $consulta_dados[1]; ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo $consulta_dados[2]; ?></h6>
                <p class="card-text"><?php echo $consulta_dados[3]; ?></p>
              </div>
            </div>

           <?php  } ?>


            <div class="row mt-5">
              <div class="col-6">
                <a href="home.php" class="btn btn-lg btn-warning btn-block btn-voltar">Voltar</a>
              </div>
            </div>

          </div>
        </div>
      </article>
    </section>
  </main>


  <footer class="text-center mt-4 mb-3 text-muted">
    <small>&copy; <?php echo date("Y"); ?> App Help Desk</small>
  </footer>

</body>
</html>
