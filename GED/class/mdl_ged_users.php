<?php
class ged_users{
    public $db;
    function __construct() {
        require_once('mysql.php'); 
        $db = new mysqlConnector();
        $this->db = $db->dataBase;
    }
    
    function haveAccess($type) {
        if($type=='right_admin'){
            $login=$_SESSION['user']['login'];
            $pass=$_SESSION['user']['password'];
            $r = $this->db->prepare("SELECT * FROM ged_users WHERE login = ? AND password = ? AND right_admin = 1");
            $r->execute([$login,$pass]);
            $n = $r->fetchAll();
            if(count($n)==1){
            }else{
                $_SESSION['message']=array("success","Vous n'avez pas l'acces1");
                header('location:index.php');
            }
        }
        if($type=='right_up'){
            $login=$_SESSION['user']['login'];
            $pass=$_SESSION['user']['password'];
            $r = $this->db->prepare("SELECT * FROM ged_users WHERE login = ? AND password = ? AND right_up = 0");
            $r->execute([$login,$pass]);
            $n = $r->fetchAll();
            if(count($n)==1){
            }else{
                $_SESSION['message']=array("success","Vous n'avez pas l'acces2");
                header('location:index.php');
            }
        }
        if($type=='right_read'){
            $login=$_SESSION['user']['login'];
            $pass=$_SESSION['user']['password'];
            $r = $this->db->prepare("SELECT * FROM ged_users WHERE login = ? AND password = ? AND right_read = 1");
            $r->execute([$login,$pass]);
            $n = $r->fetchAll();
            if(count($n)==1){
            }else{
                $_SESSION['message']=array("success","Vous n'avez pas l'acces3");
                header('location:index.php');
            }
        }
        
    }

    
    
    // function logMe($login,$pass) {
    //     $pass=sha1($pass);
    //     $r = $this->db->prepare("SELECT * FROM ged_users WHERE login = ? AND password = ?");
    //     $r->execute([$login,$pass]);
    //     $n = $r->fetchAll();
    //     if(count($n)==1){
    //         $_SESSION['user']=array(
    //             "login"=>$n['0']->login,
    //             "password"=>$n['0']->password,
    //             "username"=>$n['0']->username,
    //             "right_read"=>$n['0']->right_read,
    //             "right_up"=>$n['0']->right_up,
    //             "right_admin"=>$n['0']->right_admin
    //         );
    //         $_SESSION['message']=array("success","Vous avez été connecté");
    //         header('location:index.php');
    //     }else{
    //         $_SESSION=array();
    //         $_SESSION['message']=array("error","Vous n'avez pas l'acces 4");
    //         header('location:index.php');
    //     }  
    // }


    function logMe($login, $pass) {
        $pass = sha1($pass);
        $r = $this->db->prepare("SELECT * FROM ged_users WHERE login = ? AND password = ?");
        $r->execute([$login, $pass]);
        $n = $r->fetchAll();
        if (count($n) == 1) {
            $_SESSION['user'] = array(
                "id" => $n[0]->id, // Ajouter l'ID de l'utilisateur à la session
                "login" => $n[0]->login,
                "password" => $n[0]->password,
                "username" => $n[0]->username,
                "right_read" => $n[0]->right_read,
                "right_up" => $n[0]->right_up,
                "right_admin" => $n[0]->right_admin
            );
            $_SESSION['message'] = array("success", "Vous avez été connecté");
               
             header('location:index.php');
        } else {
            $_SESSION = array();
            $_SESSION['message'] = array("error", "Vous n'avez pas l'accès");
            header('location:index.php');
        }
    }
    



    public function getRolesByUserId($userId) {
        $stmt = $this->db->prepare("SELECT r.* FROM ged_roles r INNER JOIN ged_user_roles ur ON r.id = ur.role_id WHERE ur.user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getUserByLogin($login) {
        $stmt = $this->db->prepare("SELECT * FROM ged_users WHERE login = ?");
        $stmt->execute([$login]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserIdByLogin($login) {
        $stmt = $this->db->prepare("SELECT id FROM ged_users WHERE login = ?");
        $stmt->execute([$login]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['id'];
    }
    function islogged() {
        if(isset($_SESSION['user'])){
            $login=$_SESSION['user']['login'];
            $pass=$_SESSION['user']['password'];
            $r = $this->db->prepare("SELECT * FROM ged_users WHERE login = ? AND password = ?");
            $r->execute([$login,$pass]);
            $n = $r->fetchAll();
            if(count($n)==1){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
        
    }
    
    function getToken($login){
        $r = $this->db->prepare("SELECT * FROM ged_users WHERE login = ?");
        $r->execute([$login]);
        $n = $r->fetchAll();
        return $n['0']->token;
    }
    
    function isToken($token){
        $r = $this->db->prepare("SELECT * FROM ged_users WHERE token = ?");
        $r->execute([$token]);
        $n = $r->fetchAll();
        if(count($n)==1){
            return true;
        }else{
            return false;
        }
    }
    
    function changePass($pass,$token){
        $r = $this->db->prepare("UPDATE ged_users SET password=?,token=0 WHERE token=?");
        $r->execute([
            sha1($pass),
            $token
        ]);
    }
    
    function userNotExist($login){
        $r = $this->db->prepare("SELECT * FROM ged_users WHERE login = ?");
        $r->execute([$login]);
        $n = $r->fetchAll();
        if(count($n)==1){
            return false;
        }else{
            return true;
        }
    }
    function createUser($login,$password,$username,$rightRead,$rightUp,$rightAdmin,$token) {
        $r = $this->db->prepare("INSERT INTO ged_users SET login=?, password=?, username=?, right_read=?, right_up=?, right_admin=?, token=?");
        $r->execute([
            $login,
            $password,
            $username,
            $rightRead,
            $rightUp,
            $rightAdmin,
            $token,
        ]);
    }
    function getAllUsers() {
        $r = $this->db->prepare("SELECT * FROM ged_users");
        $r->execute([]);
        return $r->fetchAll();
    }
    function reinitUsers($id) {
        $pass=  sha1('@perso');
        $token=  sha1(time());
        $r = $this->db->prepare("UPDATE ged_users SET password=?,token=? WHERE id=?");
        $r->execute([$pass,$token,$id]);
    }
    function changeRights($rightRead,$rightUp,$rightAdmin,$id) {
        
        $r = $this->db->prepare("UPDATE ged_users SET right_read=?,right_up=?, right_admin=? WHERE id=?");
        $r->execute([$rightRead,$rightUp,$rightAdmin,$id]);
    }
    public function getUserById($userId) {
        $stmt = $this->db->prepare("SELECT * FROM ged_users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function assignRole($userId, $roleId) {
        $stmt = $this->db->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)");
        $stmt->execute([$userId, $roleId]);
    }
    
    public function getLastInsertedUserId() {
        return $this->db->lastInsertId();
    }

    public function assignUserRole($user_id, $role_id) {
        $stmt = $this->db->prepare("INSERT INTO ged_user_roles (user_id, role_id) VALUES (:user_id, :role_id)");
        // Liez les valeurs des paramètres
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':role_id', $role_id);
        // Exécutez la requête pour insérer l'association entre l'utilisateur et le rôle.
        $stmt->execute();
    }
    // public function assignUserRole($user_id, $role_id) {
    //     $stmt =$this->db->prepare( "INSERT INTO ged_user_roles (user_id, role_id) VALUES ('$user_id', '$role_id')");
    //     // Exécutez la requête pour insérer l'association entre l'utilisateur et le rôle.
    //     $stmt->execute([$user_id, $role_id]);
    // }

    // function getLastInsertedUserId() {
    //     $stmt = $this->db->prepare("SELECT LAST_INSERT_ID()");
    //     $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //     return $result['LAST_INSERT_ID()'];
    // }

    // public function getUserRoles($userId) {
    //     // Code pour récupérer les rôles de l'utilisateur à partir de la base de données
    //     // Utilisez la variable $userId pour filtrer les rôles de cet utilisateur
    //     // Exemple de requête SQL
    //     $query = "SELECT * FROM ged_user_roles WHERE user_id = :userId";
    //     $params = array(':userId' => $userId);
    //     $result = $this->db->query($query, $params);
        
    //     // Retourner les rôles trouvés
    //     return $result;
    // }

    public function getUserInfo($login) {
        $query = "SELECT * FROM ged_users WHERE login = :login";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':login', $login, PDO::PARAM_STR);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_OBJ);
    
        return $result;
    }
    
    // public function getUserRoles($userId) {
    //     $query = "SELECT * FROM ged_user_roles WHERE user_id = :userId";
    //     $stmt = $this->db->prepare($query);
    //     $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    //     $stmt->execute();
    
    //     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    //     return $result;
    // }
    

    public function getUserRoles($userId) {
        
        $query = "SELECT r.id, r.name
                  FROM ged_user_roles ur
                  INNER JOIN roles r ON ur.role_id = r.id
                  WHERE ur.user_id = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
    
        $userRoles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $userRoles;
    }
    
    public function getRoleName($roleId) {
        $query = "SELECT name FROM roles WHERE role_id = :roleId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':roleId', $roleId, PDO::PARAM_INT);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result) {
            return $result['role_name'];
        } else {
            return 'Unknown Role';
        }
    }
    

    public function getUserDataByEmail($email)
{
    $stmt = $this->db->prepare("SELECT * FROM ged_users WHERE login = ?");
    $stmt->bindValue(1, $email);
    $stmt->execute();

    // Récupérer la première ligne du résultat de la requête
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Retourner les données utilisateur (ou false si l'utilisateur n'est pas trouvé)
    return $userData ? $userData : false;
}

public function isAdmin($userId) {
    $user = $this->getUserById($userId);
    if ($user && is_array($user) && isset($user['right_admin'])) {
        if ($user['right_admin'] == 1) {
            return true;
        }
    }
    return false;
}

}