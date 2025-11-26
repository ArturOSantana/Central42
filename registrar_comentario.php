<?php
include "conn.php";
include "classes/Comentarios.php";
session_start();

$idchamado = $_POST['id_chamado'];
$comentary = $_POST['comentario'];
$idusuario = $_SESSION["id"];

echo $idchamado;
echo $comentary;

try{
    $trq = $coment = new Comentarios($idusuario,$idchamado,$comentary);
$coment->adicionarComentario($con);
header("location:ver_chamado.php?id=$idchamado");
} catch (Exception $erro){

}



?>