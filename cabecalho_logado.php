<?php 
session_start();
require_once "validador_acesso.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <title> Help Desk - Abrir Chamado</title>

  <!-- Bootstrap -->
  <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">

  <!-- CSS externo -->
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <!-- Cabeçalho -->
  <header>
    <nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand" href="index.php">
        <img src="logo.png" alt="Logo  Help Desk">
         Help Desk
      </a>
       <ul class="navbar-nav">
        <li class="nav-item">
          <a href="logoff.php" class="nav-link">
          SAIR 
         </a>
    </nav>
  </header>