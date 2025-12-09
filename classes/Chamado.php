<?php 
include "classes/Feedback.php";
class Chamado
{
    private $id;
    private $titulo;
    private $descricao;
    private $departamento_destino;
    private $usuario;
    private $status;
    private $dataAbertura;
    private $dataFechamento;

    public function __construct($titulo = "", $descricao = "", $departamento_destino = "", $usuario = "")
    {
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->departamento_destino = $departamento_destino;
        $this->usuario = $usuario;
        $this->status = "Aberto";
        $this->dataAbertura = date("Y-m-d H:i:s");
    }

    public function abrir($con)
    {


        try {

            
            // Primeiro buscar o departamento do usuário
            $sql_user = "SELECT id_departamento FROM usuarios WHERE id_usuario = :id_usuario";
            $stmt_user = $con->prepare($sql_user);
            $stmt_user->bindParam(':id_usuario', $this->usuario);
            $stmt_user->execute();
            $user_data = $stmt_user->fetch(PDO::FETCH_ASSOC);

            $id_departamento_user = $user_data['id_departamento'];

            $sql = "INSERT INTO chamados (titulo, descricao, status, id_usuario, id_departamento, departamento_destino, data_abertura) 
                VALUES (:titulo, :descricao, :status, :id_usuario, :id_departamento, :departamento_destino, :data_abertura)";

            $stmt = $con->prepare($sql);
            $stmt->bindParam(':titulo', $this->titulo);
            $stmt->bindParam(':descricao', $this->descricao);
            $stmt->bindParam(':status', $this->status);
            $stmt->bindParam(':id_usuario', $this->usuario);
            $stmt->bindParam(':id_departamento', $id_departamento_user);
            $stmt->bindParam(':departamento_destino', $this->departamento_destino);
            $stmt->bindParam(':data_abertura', $this->dataAbertura);

            $stmt->execute();
            header("location: home.php?sucesso=1");
            exit();
        } catch (PDOException $erroAoAbrirChamado) {
            echo "ERRO AO CRIAR CHAMADO: " . $erroAoAbrirChamado->getMessage();
        }
    }

    public function fechar(PDO $con, $idChamado)
    {
        $this->status = "Fechado";
        $this->dataFechamento = date("Y-m-d H:i:s");
        try {
            $sql = "UPDATE chamados 
                SET status = :status, data_fechamento = :data_fechamento 
                WHERE id_chamado = :id";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':status', $this->status);
            $stmt->bindParam(':data_fechamento', $this->dataFechamento);
            $stmt->bindParam(':id', $idChamado);
            $stmt->execute();
            header("Location: consultar_chamado.php");
        } catch (PDOException $erroaoFechar) {
            echo "ERRO AO FECHAR: " . $erroaoFechar->getMessage();
        }
    }

    public function listarPorUsuario(PDO $con, $idUsuario)
    {
        $sql = "SELECT 
                    c.*,
                    u.nome AS usuario_nome,
                    d.nome AS departamento_nome
                FROM chamados c
                LEFT JOIN usuarios u ON c.id_usuario = u.id_usuario
                LEFT JOIN departamentos d ON c.departamento_destino = d.id_departamento
                WHERE c.id_usuario = :id_usuario 
                ORDER BY c.data_abertura DESC";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':id_usuario', $idUsuario);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarPorDepartamento(PDO $con, $idDepartamento)
    {
        $sql = "SELECT 
                    c.*,
                    u.nome AS usuario_nome,
                    d.nome AS departamento_nome
                FROM chamados c
                LEFT JOIN usuarios u ON c.id_usuario = u.id_usuario
                LEFT JOIN departamentos d ON c.departamento_destino = d.id_departamento
                WHERE c.departamento_destino = :id_departamento 
                ORDER BY c.data_abertura DESC";

        $stmt = $con->prepare($sql);
        $stmt->bindParam(':id_departamento', $idDepartamento, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTodos(PDO $con)
    {
        $sql = "SELECT 
                    c.*,
                    u.nome AS usuario_nome,
                    d.nome AS departamento_nome
                FROM chamados c
                LEFT JOIN usuarios u ON c.id_usuario = u.id_usuario
                LEFT JOIN departamentos d ON c.departamento_destino = d.id_departamento
                ORDER BY c.data_abertura DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function visualizarChamado($con, $id_chamado)
    {
        try {
            $stmt = $con->prepare("SELECT 
                    c.*, 
                    u.nome AS nome_usuario,  
                    u.email,
                    d.nome AS nome_departamento   
                FROM chamados c 
                INNER JOIN usuarios u ON u.id_usuario = c.id_usuario 
                INNER JOIN departamentos d ON d.id_departamento = c.departamento_destino  
                WHERE c.id_chamado = :id");

            $stmt->bindParam(":id", $id_chamado);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $erroAoMostrarChamados) {
            echo "Erro ao mostrar os chamados: " . $erroAoMostrarChamados->getMessage();
            return false;
        }
    }

     public function reabrirChamado($con, $idchamado, $idFunc, $status){
            try{
                $stmt = $con -> prepare("UPDATE chamados SET status = 'Aberto'; ");
                $stmt -> execute();
                $stmtDeletar = $con -> prepare("DELETE FROM feedback WHERE id_chamado = ':idchamado';");
                $stmtDeletar -> bindParam(":idchamado",$idchamado);
                $stmtDeletar -> execute();
                $fed = new Feedback("","","","");
                $fed -> apagarFeedback($con,$idchamado);


            }
            catch(PDOException $erroReabertura){
                
            }
        }
}
