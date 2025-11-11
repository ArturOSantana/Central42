<?php
include "con.php";

try{
$stmy = $con->prepare("INSERT INTO usuarios(nome,email,senha,id_tipo_usuario,id_departamento) VALUES (:nome,:email,:senha,:tipo_usuario,:id_departamento);");
$stmy -> bindParam(':nome',$_POST['nome']);
$stmy -> bindParam(':email',$_POST['email']);
$stmy -> bindParam(':senha',$_POST['senha']);
$stmy -> bindParam(':tipo_usuario',$_POST['id_tipo_usuario']);
$stmy -> bindParam(':id_departamento',$_POST['id_departamento']);
$stmy -> execute();
header("location:index.php?logincomsucesso");
}
catch(PDOException $erroCadastro){

   $erro = "Erro ao Cadastrar Usuario" + $erroCadastro -> getMessage();
}



?>