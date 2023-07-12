<?php
session_start();
require_once('class/mdl_ged_users.php');
require_once('class/mdl_ged_categories.php');
$users = new ged_users();
$cat = new ged_categories();
$user_id = false; // Initialisation par défaut de $user_id
if (sha1($_POST['pass']) == '09d7154825af89fc52c5f060cf7b5020f60d051b') {
    $token = $users->getToken($_POST['login']);
    if ($token == "0") {
        // Vérifier si l'email existe et récupérer les informations de l'utilisateur
        $userData = $users->getUserDataByEmail($_POST['login']);
        if ($userData) {
            $users->logMe($_POST['login'], $_POST['pass']); // Connecter l'utilisateur et initialiser la session
            $user_id = $_SESSION['user']['id']; // Récupérer l'ID de l'utilisateur à partir de la variable de session
            if ($userData['right_admin'] === '1') {
                // Si l'utilisateur est un administrateur, rediriger vers la page dosiser.php
                header('Location: dosiser.php');
                exit;
            } else {
                // Si l'utilisateur n'est pas un administrateur, rediriger vers une autre page
                header('Location: index.php');
                exit;
            }
        } else {
            // L'utilisateur n'existe pas, rediriger vers une autre page ou afficher un message d'erreur
            header('Location: index.php');
            exit;
        }
    } else {
        header('location:passReset.php?t=' . $token);
    }
} else {
    $users->logMe($_POST['login'], $_POST['pass']);
    var_dump($_SESSION['user']);
}
if (isset($_POST['action']) && $_POST['action'] === 'role') {
    // Récupérer les rôles sélectionnés par l'utilisateur
    $selectedRoles = $_POST['roles'];
    // Stocker les rôles dans la session
    $_SESSION['selected_roles'] = $selectedRoles;
    // Déterminer le rôle sélectionné pour le paramètre d'URL
    $selectedRole = (in_array('Admin', $selectedRoles) || in_array('Administrator', $selectedRoles)) ? 'admin' : 'user';
    // Rediriger utilisateur vers la page des dossiers avec le rôle sélectionné
    header('Location: dosiser.php?selected_role=' . $selectedRole);
    exit;
} else {
    // Le formulaire n'a pas été soumis avec les rôles sélectionnés, redirigez l'utilisateur vers la page de sélection des rôles.
    header('Location: index.php');
    exit;
}
