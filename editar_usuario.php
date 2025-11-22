<?php
include "cabecalho_logado.php";
include "conn.php";
include "classes/Usuario.php";
include "classes/Departamento.php";


if ($_SESSION['id_tipo_usuario'] != 3) {
    header("Location: home.php");
  
}
//AQUI CARREGA OS USUARIOS
$usuario_obj = new Usuario("", "", "", "", "");
$dep = new Departamento();
$id_usuario = $_GET['id'];
$mensagem = "";

    $usuario = $usuario_obj->carregarUsuario($con, $id_usuario);


//AQUI SALVA AS ALTERAÇÕES 
if (isset($_POST['salvar'])) {
    $id = $_POST['id_usuario'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $tipo = $_POST['id_tipo_usuario'];
    $depto = $_POST['id_departamento'];
    
    try {
        $usuario_obj->atualizarUsuario($con, $id, $nome, $email, $tipo, $depto);
        $mensagem = "<div class='alert alert-success'>Usuário atualizado com sucesso!</div>";
        $usuario = $usuario_obj->carregarUsuario($con, $id);
    } catch (Exception $erroAtt) {
        $mensagem = "<div class='alert alert-danger'>Erro: " . $erroAtt->getMessage() . "</div>";
    }
}
?>

<main class="container mt-4">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Editar Usuário</h4>
                </div>
                <div class="card-body">
                    <?php echo $mensagem; ?>
                    
                    <?php if (isset($usuario)){ ?>
                    <form method="POST">
                        <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
                        
                        <div class="mb-3">
                            <label>Nome:</label>
                            <input type="text" class="form-control" name="nome" value="<?php echo $usuario['nome']; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label>Email:</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $usuario['email']; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label>Tipo de Usuário:</label>
                            <select class="form-control" name="id_tipo_usuario" required>
                                <option value="">Selecione</option>
                                <?php
                                $tipos = $usuario_obj->mostrarTipos($con);
                                foreach ($tipos as $tipo) {
                                    if ($tipo['id_tipo_usuario'] == $usuario['id_tipo_usuario']) {
                                        echo "<option value='{$tipo['id_tipo_usuario']}' selected>{$tipo['nome_tipo']}</option>";
                                    } else {
                                        echo "<option value='{$tipo['id_tipo_usuario']}'>{$tipo['nome_tipo']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        
                      <div class="mb-3">
                            <div class="mb-3">
                            <label>Departamento:</label>
                            <select class="form-control" name="id_departamento" required>
                                <option value="">Selecione</option>
                                <?php
                                $departamentos = $dep->mostrarDep($con);
                                foreach ($departamentos as $depto) {
                                    if ($depto['id_departamento'] == $usuario['id_departamento']) {
                                        echo "<option value='{$depto['id_departamento']}' selected>{$depto['nome']}</option>";
                                    } else {
                                        echo "<option value='{$depto['id_departamento']}'>{$depto['nome']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-6">
                                <a href="gerenciar_usuarios.php" class="btn btn-secondary w-100">Voltar</a>
                            </div>
                            <div class="col-6">
                                <button type="submit" name="salvar" class="btn btn-primary w-100">Salvar</button>
                            </div>
                        </div>
                    </form>
                    <?php }else{ ?>
                        <div class="alert alert-danger">Usuário não encontrado!</div>
                    <?php }; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include "rodape.php"; ?>