<?php
include "con.php";
session_start();

if ($_SESSION['perfil_id'] != 1 && $_SESSION['perfil_id'] != 99) {
    header("Location: consultar_chamado.php?erro=sem_permissao");
}

if (isset($_POST['id_chamado'])) {
    $id = $_POST['id_chamado'];
    $stmt = $con->prepare("UPDATE chamados SET status = 'Fechado' WHERE id_chamado = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

header("Location: consultar_chamado.php");
?>
