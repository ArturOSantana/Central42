<?php
class Usuario
{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $id_tipo_usuario;
    private $id_departamento;


    public function __construct($nome, $email, $senha, $id_tipo_usuario, $id_departamento)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->id_tipo_usuario = $id_tipo_usuario;
        $this->id_departamento = $id_departamento;
    }

    public function cadastrar($con)
    {
        try {
            $stmy = $con->prepare("INSERT INTO usuarios(nome,email,senha,id_tipo_usuario,id_departamento) VALUES (:nome,:email,:senha,:tipo_usuario,:id_departamento);");
            $stmy->bindParam(':nome', $this->nome);
            $stmy->bindParam(':email', $this->email);
            $stmy->bindParam(':senha', $this->senha);
            $stmy->bindParam(':tipo_usuario', $this->id_tipo_usuario);
            $stmy->bindParam(':id_departamento', $this->id_departamento);
            $stmy->execute();
            header("location:index.php?logincomsucesso");
        } catch (PDOException $erroCadastro) {

            $erro = "Erro ao Cadastrar Usuario" + $erroCadastro->getMessage();
        }
    }

    public function autenticar($con, $email, $senha)
    {
        try {
            $stmt = $con->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user['email'] == $_POST['email'] && $user['senha'] == $_POST['senha']) {


                $_SESSION['autenticado'] = "SIM";
                $_SESSION['id'] = $user['id_usuario'];
                $_SESSION['nome'] = $user['nome'];
                $_SESSION['id_tipo_usuario'] = $user['id_tipo_usuario'];
                $_SESSION['id_departamento'] = $user['id_departamento'];
                $_SESSION['perfil_id'] = $user['id_tipo_usuario'];

                $this->carregarInfoUsuario($con, $user['id_departamento'], $user['id_tipo_usuario'],);



                return true;
            }
        } catch (PDOException $erroaoAutenticar) {
            return false;
        }
    }
    private function carregarInfoUsuario($con, $id_departamento, $id_tipo_usuario)
    {
        try {
            $stmt = $con->prepare("SELECT nome FROM departamentos WHERE id_departamento = :dep");
            $stmt->bindParam(':dep', $id_departamento);
            $stmt->execute();
            $dep = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION["depName"] = $dep["nome"];


            $stmt = $con->prepare("SELECT nome_tipo FROM tipos_usuario WHERE id_tipo_usuario = :tipo");
            $stmt->bindParam(':tipo', $id_tipo_usuario);
            $stmt->execute();
            $tipo = $stmt->fetch(PDO::FETCH_ASSOC);
            $tipoName = $tipo["nome_tipo"];
            $_SESSION['tipo'] = strtoupper($tipoName);
        } catch (PDOException $erro) {
        }
    }

    public function listarTodos($con)
    {
        try {
            $stmt = $con->prepare("
                SELECT u.id_usuario, u.nome, u.email, u.id_tipo_usuario, u.id_departamento,
                       d.nome as departamento_nome, t.nome_tipo as tipo_nome
                FROM usuarios u
                LEFT JOIN departamentos d ON u.id_departamento = d.id_departamento
                LEFT JOIN tipos_usuario t ON u.id_tipo_usuario = t.id_tipo_usuario
                ORDER BY u.nome
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erro ao listar usuários: " . $e->getMessage());
        }
    }
    public function excluirUsuario($con, $id_usuario, $id_usuario_logado = null)
    {
        try {
            if ($id_usuario == $id_usuario_logado) {
                throw new Exception("Não é possível excluir seu próprio usuário!");
            }

            $stmt = $con->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
            $stmt->execute([$id_usuario]);
        } catch (PDOException $eerroaoapagar) {
            throw new Exception("Erro ao excluir usuário: " . $eerroaoapagar->getMessage());
        }
    }


    public function atualizarUsuario($con, $id_usuario, $nome, $email, $id_tipo_usuario, $id_departamento)
    {
        try {
            $stmt = $con->prepare("
                UPDATE usuarios 
                SET nome = ?, email = ?, id_tipo_usuario = ?, id_departamento = ?
                WHERE id_usuario = ?
            ");
            $stmt->execute([$nome, $email, $id_tipo_usuario, $id_departamento, $id_usuario]);
            return true;
        } catch (PDOException $erroUpdater) {
            throw new Exception("Erro ao atualizar usuário: " . $erroUpdater->getMessage());
        }
    }
}
