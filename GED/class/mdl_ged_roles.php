<?php
class ged_roles {
    private $db;
    public function __construct() {
        // Connexion à la base de données
        $this->db = new PDO('mysql:host=localhost;dbname=ged', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function getAllRoles() {
        $stmt = $this->db->prepare("SELECT * FROM roles");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getRoleById($roleId) {
        $stmt = $this->db->prepare("SELECT * FROM roles WHERE id = ?");
        $stmt->execute([$roleId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function createRole($name) {
        // Vérifier si le rôle existe déjà
        $checkQuery = $this->db->prepare("SELECT COUNT(*) FROM ged_roles WHERE name = ?");
        $checkQuery->execute([$name]);
        $count = $checkQuery->fetchColumn();
    
        if ($count > 0) {
            // Le rôle existe déjà, retourner une erreur ou effectuer une action appropriée
            throw new Exception("Le rôle '$name' existe déjà.");
        } else {
            // Vérifier si le nom est déjà utilisé par un autre rôle
            $checkNameQuery = $this->db->prepare("SELECT COUNT(*) FROM ged_roles WHERE name != ?");
            $checkNameQuery->execute([$name]);
            $countName = $checkNameQuery->fetchColumn();
    
            if ($countName > 0) {
                // Le nom de rôle est déjà utilisé par un autre rôle, retourner une erreur ou effectuer une action appropriée
                throw new Exception("Le nom '$name' est déjà utilisé par un autre rôle.");
            }
    
            // Insérer le rôle dans la base de données
            $insertQuery = $this->db->prepare("INSERT INTO ged_roles (name) VALUES (?)");
            $insertQuery->execute([$name]);
        }
    }

    public function getRolesByUserId($userId) {
        $stmt = $this->db->prepare("SELECT r.* FROM roles r INNER JOIN ged_user_roles ur ON r.id = ur.role_id WHERE ur.user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function linkUserRole($userId, $roleId)
{
    $stmt = $this->db->prepare("INSERT INTO ged_user_roles (user_id, role_id) VALUES (?, ?)");
    $stmt->execute([$userId, $roleId]);
    // Vous pouvez également ajouter des vérifications ici pour vous assurer que l'opération a réussi
}


    public function updateRole($roleId, $name) {
        $stmt = $this->db->prepare("UPDATE roles SET name = ? WHERE id = ?");
        $stmt->execute([$name, $roleId]);
    }

    public function deleteRole($roleId) {
        $stmt = $this->db->prepare("DELETE FROM roles WHERE id = ?");
        $stmt->execute([$roleId]);
    }
}
?>
