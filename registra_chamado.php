<?php
session_start();
require "con.php";
require "cabecalho_logado.php";
require "classes/Chamado.php";
require "classes/Categoria.php";


$id_categoria = $_POST["id_categoria"];
$cat = new Categoria();
$depresponsavel = $cat -> dept($con,$id_categoria);

$chamado  = new Chamado($_POST["titulo"],$_POST["descricao"],$_POST["id_categoria"],$depresponsavel, $_SESSION['id']);


$chamado -> abrir($con,$depresponsavel);





?>