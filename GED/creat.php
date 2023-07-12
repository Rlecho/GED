<?php

session_start();
require_once('class/mdl_ged_informations.php');
require_once('class/mdl_ged_categories.php');
require_once('class/mdl_ged_tags.php');
require_once('class/mdl_ged_users.php');
$users = new ged_users();
$ged = new ged_informations();
$cat = new ged_categories();
$tag = new ged_tags();
$m="";


$users = new ged_users();
$users->haveAccess('right_admin');
// Vérifier si l'utilisateur est un administrateur
// session_start();
// if ($_SESSION['role'] !== 'admin') {
//     // Rediriger l'utilisateur non autorisé vers une page d'erreur ou de connexion
//     header('Location: login.php');
//     exit();
// }

// Inclure le fichier contenant les fonctions de gestion des rôles
require_once('class/mdl_ged_roles.php');
$roles = new ged_roles();

// Traitement du formulaire de création d'utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = $_POST['mail'];
    $pass = sha1('@perso');
    $userName = $_POST['userName'];
    $roleId = $_POST['role'];

    if ($users->userNotExist($mail)) {
        $token = sha1(time()) . "_CREATE";
        $users->createUser($mail, $pass, $userName, $roleId, $token,1,1,1);
        $_SESSION['message'] = array("success", "Utilisateur créé");
    } else {
        $_SESSION['message'] = array("error", "L'utilisateur existe déjà");
    }

    header('Location: users.php');
    exit();
}
?>

<!-- Formulaire de création d'utilisateur -->
<form action="creat.php" method="POST">
    <label for="mail">Adresse e-mail:</label>
    <input type="email" name="mail" required>

    <label for="userName">Nom d'utilisateur:</label>
    <input type="text" name="userName" required>

    <label for="role">Rôle:</label>
    <select name="role">
        <option value="0">Aucun</option>
        <?php foreach ($roles->getAllRoles() as $role): ?>
            <option value="<?php echo $role['id']; ?>"><?php echo $role['name']; ?></option>
        <?php endforeach; ?>
    </select>

    <input type="submit" name="action" value="addUser">
</form>
