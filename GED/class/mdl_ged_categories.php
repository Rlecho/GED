<?php
class ged_categories{
    public $db;
    function __construct() {
        require_once('mysql.php');
        require_once('Dossier.php');
        $db = new mysqlConnector();
        $this->db = $db->dataBase;
    }

    public function createCategory($name, $date_arrivee, $content, $author, $referer, $id_tag,$role) {
        // Vérifier si le refer existe déjà
        $checkQuery = $this->db->prepare("SELECT COUNT(*) FROM ged_categories WHERE refer = ?");
        $checkQuery->execute([$referer]);
        $count = $checkQuery->fetchColumn();

        if ($count > 0) {
            // Le refer existe déjà, afficher un message d'erreur en JavaScript
            echo "<script>alert('Le refer $referer existe déjà.');</script>";
            echo "<script>window.location.href = 'dosiser.php';</script>";
            return; // Arrêter l'exécution de la méthode
        }
        // Insérer la nouvelle catégorie dans la base de données
        $insertQuery = $this->db->prepare("INSERT INTO ged_categories SET name = ?, date_arrivee = ?, description = ?, author = ?, refer = ?, id_tag = ?, role=? ");
        $insertQuery->execute([$name, $date_arrivee, $content, $author, $referer, $id_tag,$role]);

        // Récupérer l'identifiant du dossier nouvellement créé
        $dossierId = $this->db->lastInsertId();

        header('Location: dosiser.php');
        return $dossierId;
    }
    function updateCategory($id,$name,$date_arrivee,$content,$tag){
        $r = $this->db->prepare("UPDATE ged_categories SET name=?, date_arrivee=?, description=?, id_tag=? WHERE id=?");
        $r->execute([
            $name,
            $date_arrivee,
            $content,
            $tag,
            $id
        ]);
    }

    function deleteCategory($id){
        $r = $this->db->prepare("DELETE FROM ged_categories WHERE id=?");
        $r->execute([$id]);
        header('location:dosiser.php');
    }

    public function deleteFilesByCategory($categoryId) {
        $r = $this->db->prepare("DELETE FROM ged_files WHERE category_id = ?");
        $r->execute([$categoryId]);
    }

    function getAllCategories(){
        $r = $this->db->prepare("SELECT * FROM ged_categories");
        $r->execute();
        return $r->fetchAll();
    }
    function getCategory($id){

        $r = $this->db->prepare("SELECT * FROM ged_categories WHERE id=?");
        $r->execute([$id]);
        return $r->fetchAll();
    }

    function getCategoryb($id) {
        $r = $this->db->prepare("SELECT * FROM ged_categories WHERE id=?");
        $r->execute([$id]);
        return $r->fetch(); // Utiliser fetch() au lieu de fetchAll()
    }


public function associateTag($dossiId, $tagsId) {
    // Vérifier si le tag est vide
    if (empty($tagsId)) {
        // Afficher un message d'erreur en JavaScript
        echo "<script>alert('Vous n'avez pas sélectionné de placard. Veuillez en choisir un.');</script>";
        echo "<script>window.location.href = 'dosiser.php';</script>";
        return; // Arrêter l'exécution de la méthode
    }

    // Insérer l'association dans la base de données
    $sql = "INSERT INTO ged_doss_as_tags (dossi_id, tags_id) VALUES (?, ?)";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$dossiId, $tagsId]);
}
public function getCategoriesByUserRole($userId)
{
    $stmt = $this->db->prepare("SELECT c.*
                               FROM ged_categories AS c
                               INNER JOIN ged_user_roles AS ur ON c.role = ur.role_id
                               WHERE ur.user_id = ?");
    $stmt->execute([$userId]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}
public function assignRoleToCategory($categoryId, $roleId)
{
    $stmt = $this->db->prepare("UPDATE ged_categories SET role_id = ? WHERE id = ?");
    $stmt->execute([$roleId, $categoryId]);

    // Vérifier si la mise à jour a été effectuée avec succès
    return $stmt->rowCount() > 0;
}


public function getDossiersByRoles($selectedRoles) {
    $selectedRoles = array_map('intval', $selectedRoles);
    $rolesCondition = implode(',', $selectedRoles);

    $sql = "SELECT * FROM ged_categories WHERE role IN ($rolesCondition)";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    $dossiers = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dossier = new Dossier($row);
        $dossier->id = $row['id'];
        $dossier->name = $row['name'];
        // Assigner d'autres attributs du dossier

        $dossiers[] = $dossier;
    }

    return $dossiers;
}

public function getDossiersByRoless($selectedRoles, $searchQuery = '') {
    $query = "SELECT * FROM ged_categories WHERE role IN ('" . implode("','", $selectedRoles) . "')";
    if (!empty($searchQuery)) {
        $query .= " AND name LIKE '%" . $searchQuery . "%'";
    }
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    $dossiers = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dossiers[] = $row;
    }
    return $dossiers;
}

public function getDossiersByNameOrDescription($searchQuery = '') {
    $query = "SELECT * FROM ged_categories WHERE name LIKE '%" . $searchQuery . "%' OR description LIKE '%" . $searchQuery . "%'";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    $dossiers = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dossiers[] = $row;
    }
    
    // Vérifier si le tableau de dossiers est vide
    if (empty($dossiers)) {
        $dossiers[] = array("message" => "Aucun résultat trouvé.");
    }
    
    return $dossiers;
}

}
