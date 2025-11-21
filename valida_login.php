<?php
session_start();
require "conn.php";
$usuario_autenticado = false;
require "classes/Usuario.php";

$usuario = new Usuario("","","","","");
$email = $_POST['email'];
$senha = $_POST['senha'];

$usuario_autenticado =  $usuario -> autenticar($con, $email,$senha);



if ($usuario_autenticado == 'true') {
    $_SESSION['autenticado'] = 'SIM';
     header('Location: home.php');

} else {
    $_SESSION['autenticado'] = 'NÃO';
    header('Location: index.php?login=erro');
}
