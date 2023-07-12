<?php
session_start();
require_once("sectors/header.php");
require 'class/mdl_ged_informations.php';
require 'class/mdl_ged_files.php';
require 'class/mdl_ged_users.php';
require 'class/mdl_ged_categories.php';
require 'class/mdl_ged_tags.php';
require 'class/mdl_ged_trash.php';
$ged = new ged_informations();
$cat = new ged_categories();
$tag = new ged_tags();
$trash = new ged_trash();
$gedInfo = $ged->getGedInformations();
$catList = $cat->getAllCategories();
$tagList = $tag->getAllTags();
$fileUpl=new ged_files();
$users = new ged_users();
// $users->haveAccess('right_up');
$m="";
$selectedRoles=false;
$userId=false;
if(isset($_POST['action'])){
    if($_POST['action']=="fileUpload"){
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
    }
    if($_POST['action']=="dropFile"){
        $trash->moveToTrash($_POST['fileId']);
    }
}


$fileList=$fileUpl->getFiles();
$dossList=$cat->getAllCategories();
// Assurez-vous que les rôles sont disponibles dans la session
if (isset($_SESSION['selected_roles'])) {
    $selectedRoles = $_SESSION['selected_roles'];
    //var_dump($selectedRoles);
    // Votre code pour afficher les dossiers en fonction des rôles sélectionnés
} else {
    // Votre gestion des erreurs lorsque les rôles sélectionnés ne sont pas disponibles
    $selectedRoles=false;
    echo 'Vous êtes un admin';
}
// Récupérer les rôles sélectionnés depuis la session
//  $selectedRoles = $_SESSION['selected_roles'];

function hasAdminRole($selectedRoles) {
    $adminRolesIds = ['1']; // Remplacez ces ID par ceux correspondant à "Admin" et "Administrator"
    
    // Vérifier si $selectedRoles est un tableau valide avant de l'utiliser dans la boucle foreach
    if (is_array($selectedRoles)) {
        foreach ($selectedRoles as $roleId) {
            if (in_array($roleId, $adminRolesIds)) {
                echo 'connecté en  tant qu\'admin';
                return true;
            }
        }
    }
    return false;
}
?>
        <section class="main">
        <input type="text" id="searchInput" placeholder="Rechercher par nom de dossier">
            <hr>
            <hr>
            <center>
            <table class=" table table-striped">
                <tbody>
                <thead>
                    <tr>
                        <td>Identifiant</td>
                        <td>Nom Dossier</td>
                        <td>Référence</td>
                        <td>Date Arrivée</td>
                        <td>Gestionnaire</td>
                        <td>Nom placard</td>
                        <td>Les actions</td>
                    </tr>    
                    </thead>
                    <?php if (isset($_SESSION['user'])) 
                    $userId = $_SESSION['user']['id'];
                    $isAdmin = $users->isAdmin($userId); 
                    $hasAdminRole = hasAdminRole($selectedRoles);
                    ?>
                                <?php if ($isAdmin || $hasAdminRole): ?>
                                    <?php  $dossiers = $cat->getAllCategories(); ?>
                                    <?php foreach ($dossiers as $valu): ?>
                                        <?php
                                        if($valu->id_tag==0){
                                            $placard = "Non classé";
                                        }else{
                                            $placard = $tag->getTag($valu->id_tag)['0']->name;
                                            // $categorie = $cat->getCategory($value->category_id)['0']->date_arrivee;
                                        }
                                    ?>
                                        <tr>
                                            <td><?= $valu->id ?></td>
                                            <!-- <td><?= $categorie ?></td> -->
                                            <td><?= $valu->name ?></td>
                                            <td><?= $valu->refer ?></td>
                                            <td><?= $valu->date_arrivee ?></td>
                                            <td><?= $valu->author ?></td>
                                            <td><?= $placard ?></td> 
                                            <td style="display: flex;">
                                                <!-- Modifier le dossier -->
                                                <a href="modifier_dossier.php?id=<?php echo $valu->id; ?>" > <button class="btn btn-primary" style="margin-right:3px;"> Modifier</button> </a> 
                                                <a href="upload_file.php?id=<?php echo $valu->id; ?>" > <button class="btn btn-success" style="margin-right:3px;"> Ajouter Fichier </button>  </a> 
                                                <!-- Voir les fichiers du dossier -->
                                                <a href="voir_dossier.php?id=<?php echo $valu->id; ?>" > <button class="btn btn-warning" style="margin-right:3px;"> Voir les fichiers </button> </a>
                                                <!-- Supprimer le dossier -->
                                                <a  href="supprimer_dossier.php?id=<?php echo $valu->id; ?>&delete_files=true" onclick="return confirmDelete();"><button class="btn btn-danger">Supprimer</button></a> 
                                            </td>   
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <?php   $dossiers = $cat->getDossiersByRoles($selectedRoles); ?>
                                    <?php foreach ($dossiers as $valus): ?>
                                        <?php
                                        if($valus->id_tag==0){
                                            $placard = "Non classé";
                                        }else{
                                            $placard = $tag->getTag($valus->id_tag)['0']->name;
                                            // $categorie = $cat->getCategory($value->category_id)['0']->date_arrivee;
                                        }
                                    ?>
                                        <tr>
                                            <td><?= $valus->id ?></td>
                                            <!-- <td><?= $categorie ?></td> -->
                                            <td><?= $valus->name ?></td>
                                            <td><?= $valus->refer ?></td>
                                            <td><?= $valus->date_arrivee ?></td>
                                            <td><?= $valus->author ?></td>
                                            <td><?= $placard ?></td> 
                                            <td style="display: flex;">
                                                <!-- Modifier le dossier -->
                                                <a href="modifier_dossier.php?id=<?php echo $valus->id; ?>" > <button class="btn btn-primary" style="margin-right:3px;"> Modifier</button> </a> 
                                                <a href="upload_file.php?id=<?php echo $valus->id; ?>" > <button class="btn btn-success" style="margin-right:3px;"> Ajouter Fichier </button>  </a> 
                                                <!-- Voir les fichiers du dossier -->
                                                <a href="voir_dossier.php?id=<?php echo $valus->id; ?>" > <button class="btn btn-warning" style="margin-right:3px;"> Voir les fichiers </button> </a>
                                                <!-- Supprimer le dossier -->
                                                <a  href="supprimer_dossier.php?id=<?php echo $valus->id; ?>&delete_files=true" onclick="return confirmDelete();"><button class="btn btn-danger">Supprimer</button></a> 
                                            </td>   
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>              
                </tbody>
            </table>
            </center>
        </section>

        <script>
            document.getElementById('searchInput').addEventListener('keyup', function() {
                var searchValue = this.value.toLowerCase(); // Obtenir la valeur saisie et la convertir en minuscules

                // Parcourir les lignes du tableau et masquer celles qui ne correspondent pas à la recherche
                var rows = document.querySelectorAll('.table tbody tr');
                for (var i = 0; i < rows.length; i++) {
                    var name = rows[i].querySelector('td:nth-child(2)').textContent.toLowerCase(); // Obtenez le texte dans la colonne du nom du dossier
                    var description = rows[i].querySelector('td:nth-child(3)').textContent.toLowerCase(); // Obtenez le texte dans la colonne de la description du dossier

                    if (name.indexOf(searchValue) !== -1 || description.indexOf(searchValue) !== -1) {
                        rows[i].style.display = ''; // Correspondance trouvée, afficher la ligne
                    } else {
                        rows[i].style.display = 'none'; // Pas de correspondance, masquer la ligne
                    }
                }
            });
</script>
        <?php include("sectors/footer.php") ?>

