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

// Ajouter un ou des fichiers à un dossier existant
if (isset($_POST['action']) && $_POST['action'] == "addFile") {
    // $categoryId = $_POST['category_id'];
    // $name = $_FILES['file']['name'];
    // $tmpName = $_FILES['file']['tmp_name'];
    // $type = $_FILES['file']['type'];
    // $size = $_FILES['file']['size'];
    // $description = $_POST['description'];

    // $fileUpl->uploadFile($categoryId, $name, $tmpName, $type, $size, $description);

    $table=$_FILES;
    foreach ($table['fichier']['name'] as $key => $value) {
        $t['fichier']['name']=$table['fichier']['name'][$key];
        $t['fichier']['type']=$table['fichier']['type'][$key];
        $t['fichier']['tmp_name']=$table['fichier']['tmp_name'][$key];
        $t['fichier']['error']=$table['fichier']['error'][$key];
        $t['fichier']['size']=$table['fichier']['size'][$key];
        if($_POST['nameView']==""){
            $nameView="";
        }else{
            if($key=="0"){
                $nameView=$_POST['nameView'];
            }else{
                $nameView=$_POST['nameView']."_".$key;
            }
        }
        $fileUpl->copyFile($t,$_POST['category'],$nameView);
    }

    // Reste de votre logique de traitement ou de redirection
}



$fileList = $fileUpl->getFiles();
$dossList = $cat->getAllCategories();

include("sectors/header.php");
?>
    
    <div class="container" id="form1" style="display: block;height:6 cm;width:14cm;">
    <a href="doss.php"> <button> Retour </button> </a>
        <h2>Remplir les Dossiers</h2>
        <form id="myForm" action="" method="post" enctype="multipart/form-data">
            <div class="row " >
                <div class="form-group col-md-6"> 
                    <label for="">Télécharger:</label>
                    <input type="hidden" name="action" value="addFile" />
                    <input type="file" name="fichier[]" required multiple/>
                    <input type="hidden" name="nameView" value="" placeholder="Nom du fichier" />
                    </div>
                <div class="col-md-6">
                    <label for="">Choisir le dossier</label>
                        <select name="category" type='hidden' required>
                            <option value="0" selected >Non classé</option>
                            <?php foreach ($catList as $value): ?>
                            <option value="<?php echo $value->id; ?>" ><?php echo $value->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between;">
                <input type="submit" style="background-color: green;" value="Terminer" />
            </div>
        </form>
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