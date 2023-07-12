<?php
session_start();

require_once('class/mdl_ged_informations.php');
require_once('class/mdl_ged_users.php');
$ged = new ged_informations();
$users = new ged_users();
$gedInfo = $ged->getGedInformations();

// require_once("sectors/header.php");
echo '
<style>

a {
    text-decoration: none;
    margin: 2px;
}
.header {
    background-color:gray;
    color: #fff;
    padding: 10px;
    text-align: center; /* ajoutez cette ligne pour centrer le contenu */
}
.navbar {
    margin-bottom: 0;
    display: inline-block; /* ajoutez cette ligne pour centrer le contenu */
}
.navbar-inner {
    padding: 0;
    display: inline-block; /* ajoutez cette ligne pour centrer le contenu */
}
.nav {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: inline-block; /* ajoutez cette ligne pour centrer le contenu */
}
.nav li {
    display: inline-block;
    margin: 0 10px;
}
.nav a {
    color: #fff;
    text-decoration: none;
    padding: 10px;
}
.nav a:hover {
    background-color: #555;
}
.messageBox {
    text-align: center;
    margin-top: 10px;
    width: 300px;
}
.messageBox p {
    margin: 0;
    padding: 10px;
}
.messageBox.error {
    background-color: #f00;
}
.messageBox.success {
    background-color: #0f0;
}
.container-fluid {
    display: flex;
    justify-content: center; /* ajoutez cette ligne pour centrer le contenu */
}
.login-form {
    width: 300px;
    margin: 3 auto;
    padding: 20px;
    background-color: #f2f2f2;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.form-title {
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
}
.form-row {
    margin-bottom: 15px;
}
.form-row label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}
.form-row input[type="text"],
.form-row input[type="password"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.btn {
    display: block;
    width: 100%;
    padding: 10px;
    /* background-color: green; */
    color: white;
    text-align: center;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
.btn:hover {
    /* background-color: darkgreen; */
    font-family:area;
}
.forms {
    max-width: 100px;
    /* margin: auto 0; */
    margin-top: 2cm; 
    margin-left:4cm; 
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
}
label {
    display: block;
    font-weight: bold;
    margin-bottom: 10px;
}
select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    height: 150px; /* Ajuster la hauteur pour afficher plusieurs rôles sans défilement */
    overflow-y: auto;
}
input[type="submit"] {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: green;
    color: white;
    text-align: center;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
}
input[type="submit"]:hover {
    background-color: darkgreen;
}

</style>
';




?>


<section class="main">
    <h1>Bienvenue dans le système : <?php echo $gedInfo->ged_name; ?></h1>
    <!-- <p><?php echo $gedInfo->ged_coment; ?></p> -->
    <container class="container">
        <?php if ($users->islogged()): ?>
            <h1>Ravie de vous revoir <?php echo $_SESSION['user']['username']; ?> !</h1>
            <?php
            $userId = $_SESSION['user']['id'];
            $isAdmin = $users->isAdmin($userId);
            $userRoles = $users->getUserRoles($_SESSION['user']['id']);
            if (!empty($userRoles)) {
                // Si des rôles sont disponibles pour l'utilisateur, affichez le formulaire pour choisir les rôles
                ?>
                <form class="forms" action="login.php" method="post">
                    <label for="roles">Sélectionnez vos rôles :</label>
                    <input type="hidden" name="action" value="role" />
                    <select name="roles[]" multiple>
                        <?php
                        foreach ($userRoles as $role) {
                            $roleId = $role['id'];
                            $roleName = $role['name'];
                            echo '<option value="' . $roleId . '">' . $roleName . '</option>';
                        }
                        ?>
                    </select>
                    <input type="submit" class="btn-submit" value="Suivant" />
                </form>

                <?php
            } else {
                // Vérifiez si l'utilisateur connecté est un admin et si les rôles sélectionnés incluent "Admin" ou "Administrator"

                if ($users->isAdmin($_SESSION['user']['id']) && (in_array('Admin', $userRoles) || in_array('Administrator', $userRoles))) {
                    header('Location: dosiser.php');
                    exit;
                } else {
                    // Si aucun rôle n'est disponible pour l'utilisateur et s'il n'est pas un admin ou n'a pas sélectionné les rôles nécessaires, redirigez directement vers la page des dossiers
                    header('Location:dosiser.php');
                    exit;
                }
            }
            ?>
        <?php else: ?>
            <form action="login.php" method="post" class="login-form">
                <h1 class="form-title">Connexion</h1>
                <div class="form-row">
                    <label for="login">Identifiant :</label>
                    <input type="text" name="login" id="login" placeholder="Votre mail" required>
                </div>
                <div class="form-row">
                    <label for="pass">Mot de passe :</label>
                    <input type="password" name="pass" id="pass" placeholder="Votre mot de passe" required>
                </div>
                <div class="form-row">
                    <input type="submit" class="btn-submit" value="Connecter">
                </div>
            </form>
        <?php endif; ?>
    </container>
</section>

<?php include("sectors/footer.php") ?>