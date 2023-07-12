<?php
session_start();
require_once('class/mdl_ged_informations.php');
require_once('class/mdl_ged_files.php');
require_once('class/mdl_ged_categories.php');
require_once('class/mdl_ged_tags.php');
require_once('class/mdl_ged_trash.php');

$ged = new ged_informations();
$cat = new ged_categories();
$tag = new ged_tags();
$trash = new ged_trash();
$gedInfo = $ged->getGedInformations();
$catList = $cat->getAllCategories();
$tagList = $tag->getAllTags();

// Vérifier si un dossier est spécifié
if (isset($_GET['id'])) {
    $dossierId = $_GET['id'];
    $dossier = $cat->getCategoryb($dossierId);

    // Vérifier si le dossier existe
    if ($dossier) {

        
include("sectors/header.php");
?>           
    <div class="container" id="form1" style="display: block;height:10cm; width:15cm;">
    <a href="dosiser.php"> <button> Retour </button> </a>
        <h2>Modifier le Dossier</h2>
        <?php echo "<form action='' method='post'>";?>
                <div class="row " >
                    <div class="form-group col-md-6"> 
                        <?php echo "<input type='hidden' name='dossier_id' value='$dossierId'>"; ?>
                        <?php echo "<label> Titre du dossier:</label> <input type='text' name='title' value='" . $dossier->name . "'><br>"; ?>
                    </div>
                    <div class="form-group col-md-6"> 
                            <?php echo " <label> Date d'arrivée: </label> <input type='date' name='date_arrivee' value='" . $dossier->date_arrivee . "'><br>"; ?>
                    </div>
                </div>
                <div class="row " >
                    
                        <div class="form-group col-md-1" > 
                            <?php echo " <label> Contenu: </label> <textarea style='height:1.4cm' name='content'>" . $dossier->description . "</textarea><br>"; ?>
                        </div> 

                        <div class="form-group col-md-6">     
                            <label for="indication">Changer le Placard:</label> 
                            <select name="placard" required style='width:190px;height:50px;'>
                                    <option value="0">Non classé</option>
                                    <?php foreach ($tagList as $tag): ?>
                                        <!-- <option value="<?php echo $dossier->id; ?>"><?php echo $dossier->name; ?></option> -->
                                        <option value="<?php echo $tag->id; ?>" <?php if ($tag->id == $dossier->id_tag) echo 'selected'; ?>><?php echo $tag->name; ?></option>
                                    <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                <div style="display: flex; justify-content: space-between;">
                <?php  echo "<input type='submit'  style='background-color: green;width:100px;' value='Modifier'>"; ?>

                <?php
                    if (isset($_POST['title'])) {
                        // Votre code ici pour effectuer la modification

                        // Après avoir effectué la modification, affichez le message de succès
                        echo "<p>Dossier modifié avec succès.</p>";
                    }
                    ?>
                </div>
        <?php echo "</form>"; ?>
            
            
            </div>

           
    </div>
  
    <?php 
        // Afficher le formulaire de modification du dossier
        // echo "<form action='' method='post'>";
        // echo "<input type='hidden' name='dossier_id' value='$dossierId'>";
        // echo "Titre du dossier : <input type='text' name='title' value='" . $dossier->name . "'><br>";
        // echo "Date d'arrivée : <input type='date' name='date_arrivee' value='" . $dossier->date_arrivee . "'><br>";
        // echo "Contenu : <textarea name='content'>" . $dossier->description . "</textarea><br>";
        // echo "<input type='submit' value='Modifier'>";
        // echo "</form>";

        // Traitement du formulaire de modification
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $date_arrivee = $_POST['date_arrivee'];
            $content = $_POST['content'];
            $tag = $_POST['placard'];

            // Mettre à jour les informations du dossier
            $cat->updateCategory($dossierId, $title, $date_arrivee, $content,$tag);

            echo "Le dossier a été modifié avec succès.";
            header('location:dosiser.php');
        }
    } else {
        echo "Dossier introuvable.";
    }
} else {
    echo "Aucun dossier spécifié.";
}
