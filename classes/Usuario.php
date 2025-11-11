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
            if ($user['email'] == $_POST['email'] && $user['senha'] == $_POST['senha']){

             
                    $_SESSION['autenticado'] = "SIM";
                    $_SESSION['id'] = $user['id_usuario'];
                    $_SESSION['nome'] = $user['nome'];
                    $_SESSION['id_tipo_usuario'] = $user['id_tipo_usuario'];
                    $_SESSION['id_departamento'] = $user['id_departamento'];

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
}
