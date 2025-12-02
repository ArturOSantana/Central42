<?php 


$dsn = "mysql:host=hostname;dbname=central42";
$username = "root";
$password = "";

try{
   $con = new PDO ('mysql:host=localhost;dbname=central42',$username,$password);
   return $con;
} catch(PDOException $erroAoConectar){
    echo "Erro ao conectar";

}








?>
