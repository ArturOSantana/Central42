<?php
session_start();
require "con.php";
require "cabecalho_logado.php";

$status = "Aberto";
$hoje = date("Y/m/d");


try{

$stmt = $con ->prepare("INSERT INTO chamados(titulo,categoria,descricao,status,id_usuario,id_departamento,data_abertura) VALUES (:titulo,:cat,:descr,:status,:id_user,:id_dep,:data_ab);");
$stmt -> bindParam(":titulo",$_POST["titulo"]);
$stmt -> bindParam(":cat",$_POST["categoria"]);
$stmt -> bindParam(":descr",$_POST["descricao"]);
$stmt -> bindParam(":id_user",$_SESSION['id']);
$stmt -> bindParam(":id_dep",$_SESSION['id_departamento']);
$stmt -> bindParam(":data_ab",$hoje);
$stmt -> bindParam(":status",$status);
$stmt -> execute();
header("location:abrir_chamado.php");
} catch(PDOException $ErroAoAbrirChamado){
    echo "Erro ao Abrir Chamado" . $ErroAoAbrirChamado->getMessage();
}





?>