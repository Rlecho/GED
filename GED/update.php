<?php
session_start();
require_once('class/mdl_ged_informations.php');
require_once('class/mdl_ged_files.php');
require_once('class/mdl_ged_categories.php');
require_once('class/mdl_ged_tags.php');
require_once('class/mdl_ged_trash.php');
require_once('class/mdl_ged_users.php');
$ged = new ged_informations();
$cat = new ged_categories();
$tag = new ged_tags();
$users = new ged_users();
$trash = new ged_trash();
$gedInfo = $ged->getGedInformations();
$catList = $cat->getAllCategories();
$fileUpl=new ged_files();

$users->haveAccess('right_up');
$m="";
if(isset($_POST['action'])){
    if($_POST['action']=="fileUpdate"){
        
        $fileUpl->updateNameAndCategory($_POST['fileId'], $_POST['nameView'], $_POST['category'], $_POST['description'], $_POST['keywords']);
        
        
        var_dump($_POST);
        $v = $fileUpl->getTheFile($_POST['fileId']);
        $tagsList = $tag->getTagByFile($v->id);
        
    }
    if($_POST['action']=="updateFile"){
        $v = $fileUpl->getTheFile($_POST['fileId']);
        $tagsList = $tag->getTagByFile($v->id);
    }
    if($_POST['action']=="addTag"){
        $tag->getTagByName($_POST['tag']);
        $tag->affectTag($tag->getTagByName($_POST['tag'])->id, $_POST['fileId']);
        $v = $fileUpl->getTheFile($_POST['fileId']);
        $tagsList = $tag->getTagByFile($v->id);
    }
    if($_POST['action']=="killTag"){
        $tag->killTag($_POST['tagListId']);
        $v = $fileUpl->getTheFile($_POST['fileId']);
        $tagsList = $tag->getTagByFile($v->id);
    }
}else{
    header('location:voir_dossier.php');
}

include("sectors/header.php"); 
?>
        <section class="main">
            <form action="" method="post">
                <input type="hidden" name="action" value="fileUpdate" />
                <input type="hidden" name="fileId" value="<?php echo $v->id; ?>" />
                <label for="">Nom du Fichier</label> <br>
                <input type="text" name="nameView" placeholder="Nom du fichier" value="<?php echo $v->nameView; ?>" />
                
                <br>
                <br>
                <label for="Dossier"> Dossier</label>
                <br>
                <select name="category">
                    <option value="0" selected >Non classé</option>
                    <?php foreach ($catList as $value): ?>
                    <option value="<?php echo $value->id; ?>" <?php if($value->id==$v->category_id){echo 'selected';} ?> ><?php echo $value->name; ?></option>
                    <?php endforeach; ?>
                </select> 

                <br>
                <br>
                <label for="">Description</label>
                <br>
                <textarea name="description" placeholder="Description du fichier"><?php echo $v->description; ?></textarea>
                <br>
                <br>
                <label for=""> Mot clé</label>
                <br>
                <textarea name="keywords" placeholder="mots clé du fichier"><?php echo $v->keywords; ?></textarea>
                <br>
                <br>
                <input type="submit" style="background-color: green;" value="Mettre à jour" />
            </form>
            
            <h1>Ajouter son placard</h1>
            <ul>
                <?php foreach ($tagsList as $vtags): ?>
                <li><?php echo $tag->getTag($vtags->tag_id)['0']->name ?>
                
                <form action="" method="post">
                    <input type="hidden" name="action" value="killTag" />
                    <input type="hidden" name="fileId" value="<?php echo $v->id; ?>" />
                    <input type="hidden" name="tagListId" value="<?php echo $vtags->id; ?>" />
                    <input type="submit" style="background-color: green;" value="-" />
                </form>
                </li>
                <?php endforeach; ?>
            </ul>
            <form action="" method="post">
                <input type="hidden" name="action" value="addTag" />
                <input type="hidden" name="fileId" value="<?php echo $v->id; ?>" />
                <input type="text" name="tag" placeholder="Nom du placard" list="tags" />
                <datalist id="tags">
                    <?php foreach ($tag->getAllTags() as $ve): ?>
                    <option value="<?php echo $ve->name; ?>">
                    <?php endforeach; ?>
                </datalist>
                <input type="submit" style="background-color: green;" value="+" />
                
            </form>
        </section>
        <?php include("sectors/footer.php") ?>
