<?php  
include "cabecalho_logado.php";
include "conn.php";
include "classes/Chamado.php";

$chamado = new Chamado("","","","");
$feedback = new Feedback("","","","");
session_start();
if (isset($_POST['reabrir'])){
     $id_chamado = $_POST['id_chamado'];
     $chamado->reabrirChamado($con);
     $feedback->apagarFeedback($con,$id_chamado);
     header("location:ver_chamado.php?id=$id_chamado");
} else {
     header("location:consultar_chamado.php");
}


?>