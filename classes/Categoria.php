<?php
class Categoria
{

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
