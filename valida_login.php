<?php
session_start();
require "con.php";
$usuario_autenticado = false;
try {
    $login = $con->prepare("SELECT * FROM usuarios");
    $login->execute();
    foreach ($login->fetchAll(PDO::FETCH_ASSOC) as $usuario) {
        if ($usuario['email'] == $_POST['email'] && $usuario['senha'] == $_POST['senha']) {
            $usuario_autenticado = true;
            $usuario_id = $usuario["id_usuario"];
            $usuario_tipo_id = $usuario['id_tipo_usuario'];
            $departamento_id = $usuario["id_departamento"];
            $nomeusuario = $usuario['nome'];
            $usuarioemail = $usuario['email'];
        }
    }
} catch (PDOException $erroBuca) {
    //header("location: home.php?erronabuca".$erroBuca->getMessage());
}




$depnome = $con->prepare("SELECT nome FROM departamentos WHERE id_departamento = :id_dep;");
$depnome ->bindParam(':id_dep', $departamento_id);
$depnome -> execute();
foreach ($depnome->fetchAll(PDO::FETCH_ASSOC) as $dep)
    $depName = $dep["nome"];

$usertipo = $con->prepare("SELECT nome_tipo FROM tipos_usuario WHERE id_tipo_usuario = :id_tipo;");
$usertipo->bindParam(':id_tipo', $usuario_tipo_id);
$usertipo->execute();
$tipo = $usertipo->fetch(PDO::FETCH_ASSOC);
$tipoName = $tipo["nome_tipo"];





if ($usuario_autenticado) {
    $_SESSION['autenticado'] = 'SIM';
    $_SESSION['id'] = $usuario_id;
    $_SESSION['depName'] = $depName;
    $_SESSION['tipo'] = strtoupper($tipoName);
    $_SESSION['id_tipo_usuario'] = $usuario_tipo_id;
    $_SESSION['id_departamento'] = $departamento_id;
    $_SESSION['nome'] = $nomeusuario;
    $_SESSION['email'] = $usuarioemail;

    header('Location: home.php');
} else {
    $_SESSION['autenticado'] = 'NÃO';
    header('Location: index.php?login=erro');
}
