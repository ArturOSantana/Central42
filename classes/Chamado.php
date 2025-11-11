<?php
// Chamado.php
class Chamado
{
    private $id;
    private $titulo;
    private $descricao;
    private $categoria;
    private $departamento;
    private $usuario;
    private $status;
    private $dataAbertura;
    private $dataFechamento;


    public function __construct($titulo, $descricao, $categoria, $departamento, $usuario)
    {
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->categoria = $categoria;
        $this->departamento = $departamento;
        $this->usuario = $usuario;
        $this->status = "Aberto";
        $this->dataAbertura = date("Y-m-d H:i:s");
    }


    public function abrir(PDO $con) // PARA ABRIR O CHAMADO
    {
        try {
            $sql = "INSERT INTO chamados (titulo, id_categoria, descricao, status, id_usuario, id_departamento, data_abertura) 
                VALUES (:titulo, :categoria, :descricao, :status, :id_usuario, :id_departamento, :data_abertura)";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':titulo', $this->titulo);
            $stmt->bindParam(':categoria', $this->categoria);
            $stmt->bindParam(':descricao', $this->descricao);
            $stmt->bindParam(':status', $this->status);
            $stmt->bindParam(':id_usuario', $this->usuario);
            $stmt->bindParam(':id_departamento', $this->departamento);
            $stmt->bindParam(':data_abertura', $this->dataAbertura);
            $stmt->execute();
            header("location:abrir_chamado.php");
        } catch (PDOException $erroAoCriarChamado) {
            echo "ERRO AO CRIAR CHAMADO" . $erroAoCriarChamado->getMessage();
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
            echo "ERRO AO FECHAR" . $erroaoFechar->getMessage();
        }
    }

    public static function listarPorUsuario(PDO $con, $idUsuario) // cada usuario pode ver o seu ID = 1
    {
        $sql = "SELECT * FROM chamados WHERE id_usuario = :id_usuario ORDER BY data_abertura DESC";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':id_usuario', $idUsuario);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarPorDepartamento(PDO $con, $idDepartamento) // O ID É iGUAL 2
    {
        $sql = "SELECT * FROM chamados WHERE id_departamento = :id_departamento ORDER BY data_abertura DESC";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':id_departamento', $idDepartamento);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarTodos(PDO $con) // O ID É IGUAL 3
    {
        $sql = "SELECT * FROM chamados ORDER BY data_abertura DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
