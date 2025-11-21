<?php
session_start();


require "con.php";
require "classes/Chamado.php";


$chamado = new Chamado(
    $_POST["titulo"],
    $_POST["descricao"], 
    $_POST["departamento_destino"],
    $_SESSION['id']
);

$chamado->abrir($con);

?>