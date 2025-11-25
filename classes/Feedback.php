<?php
class Feedback
{
    private $id_chamado;
    private $id_usuario;
    private $nota;
    private $comentario;
    private $data;




    public function __construct($id_chamado, $id_usuario, $nota, $comentario)
    {
        $this->id_chamado = $id_chamado;
        $this->id_usuario = $id_usuario;
        $this->nota = $nota;
        $this->comentario = $comentario;
        $this->data = date("Y-m-d");
    }

    public function criarFeedback($con)
    {
        try {

            $stmt = $con->prepare("INSERT INTO feedbacks (id_chamado, id_usuario, nota, comentario, data_feedback) VALUES (:idch,:iduser,:nota,:comentario,:datefed);");
            $stmt->bindParam(":idch", $this->id_chamado);
            $stmt->bindParam(":iduser", $this->id_usuario);
            $stmt->bindParam(":nota", $this->nota);
            $stmt->bindParam(":comentario", $this->comentario);
            $stmt->bindParam(":datefed", $this->data);
            $stmt->execute();
        } catch (PDOException $erroAoAddFeedBack) {
            echo "ERRO" . $erroAoAddFeedBack->getMessage();
        }
    }

    public function vericarFeedback($con,$id) {
        $stmt = $con -> prepare("SELECT * FROM feedbacks WHERE id_chamado = :id;");
        $stmt -> bindParam(":id",$id);
        $stmt -> execute();
        if($stmt -> rowCount()>0){
            return $stmt -> fetch(PDO::FETCH_ASSOC);
        } else{
            return false;
        }
        

       
    }








}
