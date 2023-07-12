<?php
 ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Accueil | GED</title>
        <link rel="stylesheet" type="text/css" href="CSS/main.css" />   
        <script type="text/javascript" src="js/jq.js"></script>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="bootstrap/js/jquery.js"></script>
        <script src="bootstrap/js/bootstrap.min.js">
        </script><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
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
        max-width: 400px;
        /* margin: auto 0; */
        margin-top: 2cm; 
        margin-left:-8cm; 
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
            /* Style de la div masque */
    .mask {
        position:absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Opacité de la div masque */
        z-index: 9999; /* Assure que la div masque est en avant-plan */
        display: none; /* Cachée par défaut */
    }
    h1 {
        font-size: 24px;
        text-align: center;
        margin-top: 20px;
    }
    .addUserOpen {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: blueviolet;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    .reinituserBtn{
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: blueviolet;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    .changeRightsBtn{
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: blueviolet;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    .changeTitleBtn{
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: blueviolet;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    .changeComentsBtn{
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: blueviolet;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    .main {
        margin: 20px;
    }
    /* Styles pour les formulaires */
    .formParam {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 5px;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        max-width: 400px;
        width: 90%;
    }
    .formParam h1 {
        font-size: 20px;
        margin: 0;
        margin-bottom: 15px;
    }
    .formParam input[type="text"],
    .formParam input[type="password"],
    .formParam select,
    .formParam textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .formParam input[type="submit"],
    .formParam input[type="button"] {
        padding: 10px 20px;
        background-color: #4caf50;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    /* Styles pour la boîte de masquage */
    .mask {
        background-color: rgba(0, 0, 0, 0.5);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9998;
        display: flex;
        align-items: center;
        justify-content: center;
        display: none;
    }
</style>
    </head>
    <body>
        <section class="header">
            <div class="container-fluid">
                <nav class="navbar navbar-inverse">
                    <div class="navbar-inner" >
                        <ul class="nav">
                            <li><a href="index.php">Accueil</a></li>
                            <li><a href="folders.php">Rechercher</a></li>
                            <li><a href="parametrage.php">Parametrage</a></li>
                            <li><a href="placard.php">Créations</a></li>
                            <li><a href="trash.php">Corbeille</a></li>
                            <li><a href="logout.php">Deconnexion</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <?php if (isset($_SESSION['message'])): ?>
            <div class="messageBox <?= $_SESSION['message']['0'] ?>">
                <p><?= $_SESSION['message']['1'] ?></p>
            </div>
            <?php else: ?>
            <?php endif; ?>
            <?php unset($_SESSION['message']); ?>
        </section>
        </body>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <script>
            function confirmDelete() {
                return confirm("Voulez-vous vraiment supprimer ce dossier ?");
            }
        </script>
</html>