<?php
class AlimentosModel {
    private $db;
    public function __construct() {
        $host = "mysql-alejandrocamposhostingalimentosx2025.alwaysdata.net";
        $dbname = "alejandrocamposhostingalimentosx2025_alimentosdb";
        $user = "445174";
        $pass = "Proyectogrupal2025";

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    public function getAll() {
        $query = $this->db->prepare("SELECT * FROM alimentos");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public function getById($id) {
        $query = $this->db->prepare("SELECT * FROM alimentos WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function insert($nombre, $energia, $proteina, $hidrato, $fibra, $grasa) {
        $query = $this->db->prepare("
            INSERT INTO alimentos (nombre, energia, proteina, hidratocarbono, fibra, grasatotal)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $query->execute([$nombre, $energia, $proteina, $hidrato, $fibra, $grasa]);
        return $this->db->lastInsertId();
    }
    public function update($id, $nombre, $energia, $proteina, $hidrato, $fibra, $grasa) {
        $query = $this->db->prepare("
            UPDATE alimentos
            SET nombre = ?, energia = ?, proteina = ?, hidratocarbono = ?, fibra = ?, grasatotal = ?
            WHERE id = ?
        ");
        return $query->execute([$nombre, $energia, $proteina, $hidrato, $fibra, $grasa, $id]);
    }
    public function delete($id) {
        $query = $this->db->prepare("DELETE FROM alimentos WHERE id = ?");
        return $query->execute([$id]);
    }
    // Buscar por nombre (coincidencia parcial)
    public function searchByName($nombre) {
        $query = $this->db->prepare("SELECT * FROM alimentos WHERE nombre LIKE ?");
        $query->execute(["%" . $nombre . "%"]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    // Buscar por energía exacta
    public function searchByEnergia($energia) {
        $query = $this->db->prepare("SELECT * FROM alimentos WHERE energia = ?");
        $query->execute([$energia]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}

?>
