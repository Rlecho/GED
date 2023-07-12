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
$gedInfo = $ged->getGedInformations();
$catList = $cat->getAllCategories();
$tagList = $tag->getAllTags();
$fileUpl=new ged_files();
require_once('class/mdl_ged_users.php');
$users = new ged_users();
// $users->haveAccess('right_up');
$m="";
if(isset($_POST['action'])){
    if($_POST['action']=="dropFile"){
        $trash->moveToTrash($_POST['fileId']);
    }
}
// Vérifier si un dossier est spécifié
if (isset($_GET['id'])) {
    $dossierId = $_GET['id'];
    $dossier = $cat->getCategoryb($dossierId);

    if($dossier->id_tag==0){
        $placard = "Non classé";
    }else{
        $placard = $tag->getTag($dossier->id_tag)['0']->name;
        // $categorie = $cat->getCategory($value->category_id)['0']->date_arrivee;
    }
 
 echo '<button class="btn btn-default" style="background-color:purple;width:100px;margin:10px; height:1cm;" >  <a href="dosiser.php" style="text-decoration:none; color:white;" >  Retour  </a></button>';
   echo'<h1> Les informations sur le Dossier </h1>';
    // Vérifier si le dossier existe
    if ($dossier) {
        // Récupérer les fichiers associés au dossier
        $files = $fileUpl->getFilesByCategory($dossierId);
        // Afficher les informations du dossier
        if ($dossier->name) {
            echo " <label> Titre du dossier:" . $dossier->name . "</label>";
        }
        if ($dossier->date_arrivee) {
            echo "<label> Date d'arrivée:" . $dossier->date_arrivee ."</label>";
        }
        if ($dossier->description) {
            echo " <label> Contenu:  " . $dossier->description . "</label>";
        }
         if ($dossier->refer) {
            echo " <label> Référence: " . $dossier->refer . "</label> ";
        }
        if ($placard) {
            echo "<label> Placard:  " . $placard . "</label>";
        }
?>
    <h1>Les fichiers liés au dossier</h1>
        <table border="2" class=" table table-striped">
        <tbody>
        <thead>
            <tr>
                <td>Identifiant</td>
                <td>Nom fichier</td>
                <td>Date Arrivée</td>
                <td>Date système</td>
                <td>Les actions</td>
            </tr>    
            </thead>
            <?php foreach ($files as $file): ?>
                <?php
                        if($file->category_id==0){
                            $category = "Non classé";
                        }else{
                            $category = $cat->getCategory($file->category_id)['0']->name;
                            $categorie = $cat->getCategory($file->category_id)['0']->date_arrivee;
                        } 
                    ?>
                <tr>
                    <td><?= $file->id ?></td>
                    <td><a href="<?= $file->url ?>" target='blank'><?= $file->name ?></a></td>
                    <td><?= $categorie ?></td>
                    <td><?= $file->date ?></td>
                    <td>
                    <form action="" method="post">
                        <input type="hidden" name="action" value="dropFile" />
                        <input type="hidden" name="fileId" value="<?= $file->id ?>" />
                        <input type="submit" style="background-color: green;" value="Effacer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce fichier ?');" />
                    </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php 
    } else {
        echo "Dossier introuvable.";
    }
} else {
    echo "Aucun dossier spécifié.";
}
?>
