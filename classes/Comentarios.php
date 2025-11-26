<?php
class Comentarios
{

    private $id_usuario;
    private $id_chamado;
    private $comentario;
    private $data;

    public function __construct($id_usuario, $id_chamado, $comentario)
    {
        $this->id_usuario = $id_usuario;
        $this->id_chamado = $id_chamado;
        $this->comentario = $comentario;
        $this->data = date("Y-m-d H:i");
    }


    public function adicionarComentario($con)
    {
        try {
            $stmt = $con->prepare("INSERT INTO comentarios(id_chamado,id_usuario,comentario,data_comentario) VALUES (:idchamado,:idusuario,:comentario,:dataco);");
            $stmt->bindParam(":idchamado", $this->id_chamado);
            $stmt->bindParam(":idusuario", $this->id_usuario);
            $stmt->bindParam(":comentario", $this->comentario);
            $stmt->bindParam(":dataco", $this->data);
            $stmt->execute();
        } catch (PDOException $erroAoEnviarComentario) {
            echo "erro ao adicionar ao banco" . $erroAoEnviarComentario;
        }
    }



    public function mostrarComentarios($con, $id)
    {
        try {
            $stmt = $con->prepare("SELECT c.comentario, c.data_comentario, u.nome, d.nome as nome_departamento
                                    FROM comentarios as c 
                                    INNER JOIN usuarios as u ON u.id_usuario = c.id_usuario
                                    INNER JOIN departamentos as d ON d.id_departamento = u.id_departamento 
                                    WHERE c.id_chamado = :id
                                    ORDER BY c.data_comentario ASC");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $erroAoMostrarComentario) {
            echo "erro" . $erroAoMostrarComentario;
            return null;
        }
    }
}
