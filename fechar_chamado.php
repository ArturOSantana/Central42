<?php
include "con.php";
include "classes/Chamado.php";
session_start();

$idchamado = $_GET["id_chamado"];
$chamado = new Chamado("","","","","");
$chamado -> fechar($con,$idchamado) //FECHA O CHAMADO;



?>
