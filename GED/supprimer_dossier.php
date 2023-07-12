<?php

session_start();
require_once('class/mdl_ged_informations.php');
require_once('class/mdl_ged_files.php');
require_once('class/mdl_ged_categories.php');
require_once('class/mdl_ged_tags.php');
require_once('class/mdl_ged_trash.php');
include("sectors/header.php");
$ged = new ged_informations();
$cat = new ged_categories();
$tag = new ged_tags();
$trash = new ged_trash();
// Récupérer l'ID du dossier à supprimer
$dossierId = $_GET['id'];
// Vérifier si l'utilisateur a confirmé la suppression
if (isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    $dossierId = $_GET['id'];

    // Supprimer les fichiers associés au dossier
    $cat->deleteFilesByCategory($dossierId);

    // Supprimer le dossier
    $cat->deleteCategory($dossierId);

    // Rediriger ou afficher un message de succès
    header('location: dosiser.php');
} else {
    // Afficher l'alerte de confirmation
    echo '<script>
            function confirmDelete() {
                return confirm("Êtes-vous sûr de vouloir supprimer ce dossier ?");
            }

            if (confirmDelete()) {
                window.location.href = "supprimer_dossier.php?id=' . $dossierId . '&confirm=true";
            } else {
                window.location.href = "index.php";
            }
          </script>';
}

