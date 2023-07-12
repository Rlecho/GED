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
$fileUpl = new ged_files();
require_once('class/mdl_ged_users.php');
$users = new ged_users();
// $users->haveAccess('right_up');

$m = "";

// Créer un nouveau tag
if (isset($_POST['action']) && $_POST['action'] == "createTag") {
    $tagName = $_POST['tag_name'];
    $tagDesc = $_POST['tag_description'];
    
    $tag->createTag($tagName, $tagDesc);
}


$fileList = $fileUpl->getFiles();
$dossList = $cat->getAllCategories();

include("sectors/header.php");
?>


    <!-- Formulaire pour créer un tag -->           
<div class="container" id="form1" style="display: block; width: 13cm;" >
<a href="index.php"> <button> Retour </button> </a>
        <h2>Création du Placard</h2>
        <form id="myForm" action="" method="post">
            <div class="row " >
                <div class="form-group col-md-6"> 
                    <label for="">Nom du Placard:</label>
                    <input type="hidden" name="action" value="createTag">
                    <input type="text" name="tag_name" placeholder="Nom du tag" required>
                    </div>
                <div class="col-md-6">
                    <label for="">Description</label>    
                    <input type="text" name="tag_description" placeholder="description du tag">
                </div>
            </div>

            <div style="display: flex; justify-content: space-between;">
                <input type="submit" value="Suivant">
            </div>
        </form>
        <!-- <a href="doss.php" style="float: right;"> <button>Suivant</button> </a> -->
    </div>

<?php include("sectors/footer.php") ?>






<!-- Formulaire pour ajouter un fichier à un dossier -->
<!-- <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="addFile">
    <select name="category_id">
        <option value="">Sélectionner un dossier</option>
        <?php foreach ($dossList as $dossier): ?>
            <option value="<?php echo $dossier->id; ?>"><?php echo $dossier->name; ?></option>
        <?php endforeach; ?>
    </select>
    <input type="file" name="file">
    <textarea name="description" placeholder="Description du fichier"></textarea>
    <input type="submit" value="Ajouter le fichier">
</form> -->