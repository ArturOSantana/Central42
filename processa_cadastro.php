<?php
include "con.php";
include "classes/Usuario.php";



$Novousuario = new Usuario($_POST['nome'],$_POST["email"],$_POST["senha"],$_POST["id_tipo_usuario"],$_POST["id_departamento"]);

$Novousuario -> cadastrar($con);



?>