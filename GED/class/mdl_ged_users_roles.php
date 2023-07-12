<?php

class Mdl_Ged_Users_Roles
{
    private $db; // Instance de connexion à la base de données

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function assignUserRole($user_id, $role_id) {
        $query = "INSERT INTO ged_user_roles (user_id, role_id) VALUES ('$user_id', '$role_id')";
        // Exécutez la requête pour insérer l'association entre l'utilisateur et le rôle.
       
    }
}
