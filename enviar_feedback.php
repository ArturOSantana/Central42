<?php  
include "conn.php";
include "classes/Feedback.php";
session_start();

$idChamado = $_POST["id_chamado"];
$nota = $_POST["nota"];
$comentarios = $_POST['comentarios'];



try{
$avalicao = new Feedback($idChamado,$_SESSION['id'],$nota,$comentarios);
$avalicao -> criarFeedback($con);
header("location:ver_chamado.php?id=$idChamado");

}
catch(PDOException $erroAoenviarAvaliacao){
    echo "erro".$erroAoenviarAvaliacao -> getMessage();
}

?>