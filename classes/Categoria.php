<?php
class Categoria
{

    public function dept($con, $idCategoria)
{
    $sql = "SELECT id_departamento FROM categorias WHERE id_categoria = :id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(":id", $idCategoria);
    $stmt->execute();
    return $stmt->fetchColumn(); 
}


    public function exibirCategorias($con)
    {
        $stmt = $con->prepare(
            "SELECT 
         c.id_categoria, 
         c.nome_categoria, 
         d.nome AS nome_departamento
        FROM categorias AS c
        INNER JOIN departamentos AS d 
        ON c.id_departamento = d.id_departamento
        ORDER BY d.nome, c.nome_categoria"
        );
        $stmt->execute();
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $categorias;
    }
}
