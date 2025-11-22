<?php
class Departamento
{


     public function mostrarDep($con)
    {
        try {
            $stmt = $con->prepare("SELECT * FROM departamentos");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erro ao carregar departamentos: " . $e->getMessage());
        }
    }
}
