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
require_once('class/mdl_ged_roles.php');
$roles = new ged_roles();
require_once('class/mdl_ged_users.php');
$users = new ged_users();
// $users->haveAccess('right_up');

$m = "";

// Créer un nouveau dossier
if (isset($_POST['action']) && $_POST['action'] == "createFolder") {
    // $categoryData = array(
    //     'title' => $_POST['title'],
    //     'date_arrivee' => $_POST['date_arrivee'],
    //     'content' => $_POST['content'],
    //     'author' => $_POST['author'],
    //     'referrer' => $_POST['referrer'],
    //     'placard' => $_POST['placard']
    // );
    $title = $_POST['title'];
    $date_arrivee = $_POST['date_arrivee'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    $referrer = $_POST['referrer'];
    $id_tag = $_POST['placard'];
    $role = $_POST['role'];

    $dossId = $cat->createCategory($title , $date_arrivee, $content, $author, $referrer, $id_tag,$role);

    // Associer le tag sélectionné au dossier créé
    $tagsId = $_POST['placard'];
    $cat->associateTag($dossId, $tagsId);

  // Attribuer le rôle au dossier
  $mdl_ged_categories->assignRoleToCategory($folderId, $roleId);
    // Reste de votre logique de traitement ou de redirection
}

$fileList = $fileUpl->getFiles();
$dossList = $cat->getAllCategories();

include("sectors/header.php");
?>

   <!-- Formulaire pour créer un dossier -->  
 <div class="container" id="form1" style="width:13cm;height:14.5cm" >
 <a href="placard.php"> <button> Retour </button> </a>
                <h2>Créer Dossier</h2>
    <form id="myForm" action="" method="post">
      
        <div class="row " >
            <div class="form-group col-md-6">
                <input type="hidden" name="action" value="createFolder">
                <label for="name">Nom du Dossier:</label>
                <input type="text" name="title" placeholder="Titre du dossier" required>
            </div>
            <div class="form-group col-md-6">
                <label for="email">Date Arrivée:</label>
                <input type="date" name="date_arrivee" placeholder="Date d'arrivée" required>
            </div>
        </div>
     
        <div class="row " >
            <div class="form-group col-md-6">
                <label for="pays">Référence:</label>
                <input type="text" name="referrer" placeholder="Référence" required>
            </div>
            <div class="form-group col-md-6">
                <label for="ville">Gestionnaire:</label>
                <input type="text" name="author" placeholder="Gestionnaire" required>
            </div>
        </div>

        <div class="row " >
            <div class="form-group col-md-6" >
                <label for="quatier">Description:</label>
                <textarea name="content" placeholder="Description" style="height:1.3cm;"></textarea>
            </div>

            <div class="form-group col-md-6 " >
                <label for="indication">Choisir le Placard:</label> 
                <select name="placard" required  style="height:1.3cm;">
                        <option value="0">Non classé</option>
                        <?php foreach ($tagList as $value): ?>
                            <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                        <?php endforeach; ?>
                </select>
            </div>
        </div>
        <label for="role">Rôle:</label>
    <select name="role"  style="height:1.3cm;">
        <option value="0">Aucun</option>
        <?php foreach ($roles->getAllRoles() as $role): ?>
            <option value="<?php echo $role['id']; ?>"><?php echo $role['name']; ?></option>
        <?php endforeach; ?>
    </select>

        <div style="display: flex; justify-content: space-between;">
        <input type="submit" value="Suivant">
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