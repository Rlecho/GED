<?php
session_start();

// Vérifier si l'utilisateur est déjà connecté, le rediriger vers la page d'accueil
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Inclure le fichier contenant les fonctions de gestion des utilisateurs et des rôles
require_once('class/mdl_ged_users.php');
require_once('class/mdl_ged_roles.php');
$users = new ged_users();
$roles = new ged_roles();

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Vérifier les informations de connexion
    $user = $users->getUserByLogin($login);

    if ($user && password_verify($password, $user['password'])) {
        // Stocker les informations de l'utilisateur dans la session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['login'] = $user['login'];

        // Récupérer les rôles associés à l'utilisateur
        $userRoles = $roles->getUserRoles($user['id']);
        $_SESSION['roles'] = $userRoles;

        // Rediriger vers la page d'accueil
        header('Location: index.php');
        exit();
    } else {
        // Identifiants invalides, afficher un message d'erreur
        $error = "Identifiants invalides.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <label for="login">Email :</label>
        <input type="text" name="login" required>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required>
        
        <?php if (isset($_SESSION['roles'])) : ?>
            <label for="role">Rôle :</label>
            <select name="role[]" multiple required>
                <?php foreach ($_SESSION['roles'] as $role) : ?>
                    <option value="<?php echo $role['id']; ?>"><?php echo $role['name']; ?></option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>

        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
