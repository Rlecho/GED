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
$fileUpl=new ged_files();
require_once('class/mdl_ged_users.php');
$users = new ged_users();
$users->haveAccess('right_up');



$m="";



if(isset($_POST['action'])){
   

    if($_POST['action']=="dropFile"){
        $trash->moveToTrash($_POST['fileId']);
    }
}
$fileList=$fileUpl->getFiles();

include("sectors/header.php"); 
?>
        <section class="main">
   
            
            <hr>
            <center>
            <table border="2">
                <tbody>
                <thead>
                    <tr>
                        <td>Identifiant</td>
                        <td>Nom fichier</td>
                        <td>Date Arrivée</td>
                        <td>Date système</td>
                        <td>Nom dossier</td>
                        <td>Nom placard</td>
                        <td>Les actions</td>
                    </tr>    

                    </thead>
                    <?php foreach ($fileList as $value): ?>
                    <?php
                        if($value->category_id==0){
                            $category = "Non classé";
                        }else{
                            $category = $cat->getCategory($value->category_id)['0']->name;
                            $categorie = $cat->getCategory($value->category_id)['0']->date_arrivee;
                        }
                        

                        // if($value->tag_id==0){
                        //     $tag = "Choisir un placard";
                        // }else{
                        //     $tag = $cat->getTag($value->tag_id)['0']->name;
                        // }
                        $tagListOfTheFile = $tag->getTagByFile($value->id);
                    ?>
              
                        <tr>
                            <td><?= $value->id ?></td>
                            <td><a href="<?= $value->url ?>" target='blank'><?= $value->nameView ?></a></td>
                            <td><?= $categorie ?></td>
                            <td><?= $value->date ?></td>
                            <td><?= $category ?></td>
                            <td>
                                    <?php foreach ($tagListOfTheFile as $v): ?>
                                <span><a href="#"><?php echo $tag->getTag($v->tag_id)['0']->name; ?></a></span>
                                    <?php endforeach; ?>
                            </td>
                            <td>
                                <form action="update.php" method="post">
                                    <input type="hidden" name="action" value="updateFile" />
                                    <input type="hidden" name="fileId" value="<?= $value->id ?>" />
                                    <input type="submit" style="background-color: green;" value="Modifier" />
                                </form>
                            </td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="action" value="dropFile" />
                                    <input type="hidden" name="fileId" value="<?= $value->id ?>" />
                                    <input type="submit" style="background-color: green;" value="Effacer" />
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </center>
        </section>
        <?php include("sectors/footer.php") ?>
