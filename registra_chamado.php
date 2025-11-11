<?php
session_start();
require "con.php";
require "cabecalho_logado.php";
require "classes/Chamado.php";

$chamado  = new Chamado($_POST["titulo"],$_POST["descricao"],$_POST["id_categoria"],$_SESSION['id_departamento'],$_SESSION['id']);


$chamado -> abrir($con); // ABRI CHAMADO 




?>