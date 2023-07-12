<?php
session_start();
require_once('class/mdl_ged_informations.php');
require_once('class/mdl_ged_categories.php');
require_once('class/mdl_ged_tags.php');
require_once('class/mdl_ged_users.php');
$users = new ged_users();
$ged = new ged_informations();
$cat = new ged_categories();
$tag = new ged_tags();
require_once('class/mdl_ged_roles.php');
$roles = new ged_roles();
$m="";



$users->haveAccess('right_admin');

if(isset($_POST['action'])){
if($_POST['action']=="changeTitle"){
    $m=$ged->changeTitle($_POST['title']);
}
if($_POST['action']=="changeComents"){
    $m=$ged->changeContent($_POST['content']);
}
if($_POST['action']=="reinitUser"){
    $users->reinitUsers($_POST['user']);
    $_SESSION['message']=array("success","utilisateur réinitialisé");
}
if($_POST['action']=="changeRights"){
        if(isset($_POST['rightAdmin'])){
            $rightAdmin = 1;
        }else{
            $rightAdmin = 0;
        }
        if(isset($_POST['rightRead'])){
            $rightRead = 1;
        }else{
            $rightRead = 0;
        }
        if(isset($_POST['rightUp'])){
            $rightUp = 1;
        }else{
            $rightUp = 0;
        }
        $users->changeRights($rightRead, $rightUp, $rightAdmin, $_POST['user']);
    $_SESSION['message']=array("success","droits modifiés");
}
// if($_POST['action']=="addUser"){
//     if($users->userNotExist($_POST['mail'])){
//         $token = sha1(time())."_CREATE";
//         if(isset($_POST['rightAdmin'])){
//             $rightAdmin = 1;
//         }else{
//             $rightAdmin = 0;
//         }
//         if(isset($_POST['rightRead'])){
//             $rightRead = 1;
//         }else{
//             $rightRead = 0;
//         }
//         if(isset($_POST['rightUp'])){
//             $rightUp = 1;
//         }else{
//             $rightUp = 0;
//         }
//         $pass=  sha1('@perso');
//         $users->createUser($_POST['mail'], $pass, $_POST['userName'], $rightRead, $rightUp, $rightAdmin, $token);
//         $_SESSION['message']=array("success","utilisateur créer");
        
//     }else{
//         //l'utilisateur existe deja
//         $_SESSION['message']=array("error","L'utilisateur existe déja");
//     }
    
// }
// Traitement du formulaire de création d'utilisateur
// if ($_SERVER['REQUEST_METHOD'] === 'POST')
// if($_POST['action']=="addUser")
// {
//     $mail = $_POST['mail'];
//     $pass = sha1($_POST['pass']);
//     $userName = $_POST['userName'];
//     if(isset($_POST['rightAdmin'])){
//              $rightAdmin = 1;
//          }else{
//              $rightAdmin = 0;
//          }
//          if(isset($_POST['rightRead'])){
//              $rightRead = 1;
//          }else{
//              $rightRead = 0;
//          }
//          if(isset($_POST['rightUp'])){
//              $rightUp = 1;
//          }else{
//              $rightUp = 0;
//          }
//     $roleId = $_POST['role'];

//     if ($users->userNotExist($mail)) {
//         $token = sha1(time()) . "_CREATE";
//         $users->createUser($mail, $pass, $userName, $rightRead, $rightUp, $rightAdmin, $token, $roleId);
//         $_SESSION['message'] = array("success", "Utilisateur créé");
//     } else {
//         $_SESSION['message'] = array("error", "L'utilisateur existe déjà");
//     }

//     header('Location: users.php');
//     exit();
// }


    if (isset($_POST['action']) && $_POST['action'] == "addUser") {
        // Récupérer les données du formulaire
        $mail = $_POST['mail'];
        $pass = sha1($_POST['pass']);
        $userName = $_POST['userName'];
        $rightAdmin = isset($_POST['rightAdmin']) ? 1 : 0;
        $rightRead = isset($_POST['rightRead']) ? 1 : 0;
        $rightUp = isset($_POST['rightUp']) ? 1 : 0;
        // $roleId = $_POST['role_id'];
        
    
        // Créer l'utilisateur dans la table "ged_users"
        if ($users->userNotExist($mail)) {
            $token = sha1(time()) . "_CREATE";
            $users->createUser($mail, $pass, $userName, $rightRead, $rightUp, $rightAdmin, $token);
           
            // $selectedRoles = $_POST['roles'];
            // $user_id = $users->getLastInsertedUserId();
           
            // foreach ($selectedRoles as $role_id) 
            // {
            //     $users->assignUserRole($user_id, $role_id);
            // }
    
            // $selectedRoles = [];
            //     foreach ($roles->getAllRoles() as $role) 
            //     {
            //         $selectedRoles[] = [
            //             'id' => $role['id'],
            //             'name' => $role['name'],
            //         ];
            //     }



            $user_id = $users->getLastInsertedUserId();
            // Supposons que vous ayez récupéré les rôles sélectionnés par l'utilisateur dans un tableau appelé $selectedRoles
            
            // $selectedRoles = isset($_POST['roles']) ? $_POST['roles'] : [];

            // foreach ($selectedRoles as $role_id) {
                
            //      $users->assignUserRole($user_id, $role_id);
            //      var_dump($role_id);
            //      die;
            //   }
            

            // $selectedRoles = isset($_POST['roles']) ? json_decode($_POST['roles']) : [];
            //$selectedRoles = isset($_POST['roles']) ? json_decode($_POST['roles'], true) : [];

            // $selectedRoles = isset($_POST['roles']) ? json_decode($_POST['roles'], true) : [];

            // foreach ($selectedRoles as $role) {
            //     $role_id = $role['id'];
            //     $users->assignUserRole($user_id, $role_id);
            // }


            // parse_str($_POST['roles'], $selectedRoles);

            // foreach ($selectedRoles as $role_id) {
            //     $users->assignUserRole($user_id, $role_id);
            // }


            // $selectedRoles = isset($_POST['roles']) ? $_POST['roles'] : '';

            // if ($selectedRoles) {
            //     parse_str($selectedRoles, $roles);
                
            //     foreach ($roles as $role_id) {
            //         $users->assignUserRole($user_id, $role_id);
            //     }
            // }

            if (isset($_POST['roles'])) {
                $selected_roles = $_POST['roles']; // Récupérer les rôles sélectionnés
            
                // Parcourir les rôles sélectionnés et associer chaque rôle à l'utilisateur
                foreach ($selected_roles as $role_id) {
                    $users->assignUserRole($user_id, $role_id);
                }
            }




            $_SESSION['message'] = array("success", "Utilisateur créé");
        //     var_dump($selectedRoles);
        //    die();
        } 
        else 
        {
            $_SESSION['message'] = array("error", "L'utilisateur existe déjà");
        }
    
        header('Location: parametrage.php');
        exit();
    }
    
// if($_POST['action']=="newCategory"){
//     foreach( $catList  as $valu) {
//     $name=$_POST['title'];
//     $date_arrivee=$_POST['date_arrivee'];
//     $content=$_POST['content'];
//     $cat->createCategory($name,$date_arrivee, $content);
//   }
// }
// if($_POST['action']=="newTag"){
//     $name=$_POST['title'];
//     $content=$_POST['content'];
//     $tag->createTag($name, $content);
// }
 }

$usersList = $users->getAllUsers();
$categoriesList=$cat->getAllCategories();
$gedInfo = $ged->getGedInformations();
$tagList = $tag->getAllTags();
include("sectors/header.php"); 
if($m!=""){
echo "<div class=\"".$m[0]."\">".$m[1]."</div>";
}



$m="";
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


?>
    <section class="main">
        <script>
        $(document).ready(function() {
            $(".mask").hide();
            $("form").hide();
            $('.addUserOpen').click(function(e){
                e.preventDefault;
                $(".mask").fadeIn(500);
                $(".addUserForm").fadeIn(500);
            });
            //reinituserBtn
            $('.reinituserBtn').click(function(e){
                e.preventDefault;
                $(".mask").fadeIn(500);
                $(".reinituser").fadeIn(500);
            });
            //changeRights
            $('.changeRightsBtn').click(function(e){
                e.preventDefault;
                $(".mask").fadeIn(500);
                $(".changeRights").fadeIn(500);
            });
            //changeTitleBtn
            $('.changeTitleBtn').click(function(e){
                e.preventDefault;
                $(".mask").fadeIn(500);
                $(".changeTitle").fadeIn(500);
            });
            //changeComentsBtn
            $('.changeComentsBtn').click(function(e){
                e.preventDefault;
                $(".mask").fadeIn(500);
                $(".changeComents").fadeIn(500);
            });
            //newCategory
            $('.newCategoryBtn').click(function(e){
                e.preventDefault;
                $(".mask").fadeIn(500);
                $(".newCategory").fadeIn(500);
            });
            //newTagBtn
            $('.newTagBtn').click(function(e){
                e.preventDefault;
                $(".mask").fadeIn(500);
                $(".newTag").fadeIn(500);
            });
            $('.mask').click(function(e){
                e.preventDefault;
                $(".mask").fadeOut(500);
                $("form").fadeOut(500);
            });
            });
        </script>

        <div class="mask"></div>
        <h1>Utilisateurs de la  <?php echo $gedInfo->ged_name; ?></h1>
        <input class="addUserOpen" type="button" value="Créer un utilisateur"/>
        <form action="" method="post" class="addUserForm formParam">
            <input type="hidden" name="action" value="addUser"/>
            <h1>Ajouter un utilisateur</h1>
            <input type="text" name="userName" placeholder="Nom d'utilisateur" value=""/>
            <input type="password" name="pass" value="Mot de passe"/>
            <input type="text" name="mail" placeholder="Identifiant" value=""/>
            <p>Administrateur : <input type="checkbox" name="rightAdmin" value="1"/></p>
            <p>Utilisateur : <input type="checkbox" name="rightRead" value="1"/></p>
            <p>Gestionnaire : <input type="checkbox" name="rightUp" value="1"/></p>
            <label for="roles">Rôles :</label>
            <div class="custom-select">
    <!-- <input type="text" id="selected-roles" readonly placeholder="Sélectionner un rôle"> -->
    <!-- <span class="select-arrow">&#9660;</span> -->
            <div class="custom-select">
                <select id="selected-roles" multiple>
                    <?php foreach ($roles->getAllRoles() as $role): ?>
                        <option value="<?php echo $role['id']; ?>"><?php echo $role['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            </div>
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        </div>
            <input type="submit" style="background-color: green;" value="Créer l'utilisateur" />
        </form>

        <input class="reinituserBtn" type="button" value="Réinitialiser un mot de passe"/>
        <form action="" method="post" class="reinituser formParam">
            <input type="hidden" name="action" value="reinitUser"/>
            <h1>Réinitialiser un user</h1>
            <select name="user">
                <?php foreach ($usersList as $var): ?>
                <option value="<?php echo $var->id; ?>"><?php echo $var->username; ?> | <?php echo $var->login; ?></option>
                <?php endforeach; ?>
                
            </select>
            <input type="submit" style="background-color: green;" value="Restaurer le compte"/>
        </form>
               
        <!-- <input class="changeRightsBtn" type="button" value="Réinitialiser les droits d'un utilisateur"/>
        <form action="" method="post" class="changeRights formParam">
            <input type="hidden" name="action" value="changeRights"/>
            <h1>Gérrer les droits</h1>
            <select name="user">
                <?php foreach ($usersList as $var): ?>
                <option value="<?php echo $var->id; ?>"><?php echo $var->username; ?> | <?php if($var->right_admin=="1"){echo "Admin:OUI";}else{echo "Admin:NON";} ?> | <?php if($var->right_up=="1"){echo "Gestion:OUI";}else{echo "Gestion:NON";} ?> | <?php if($var->right_read=="1"){echo "Utilisateur:OUI";}else{echo "Utilisateur:NON";} ?></option>
                <?php endforeach; ?>-->

        <h1>Informations de <?php echo $gedInfo->ged_name; ?> </h1> 

        <input class="changeTitleBtn" type="button" value="Modifier le titre de cet Gestionnaire éléctronique"/>
        <form action="" method="post" class="changeTitle formParam">
            <input type="hidden" name="action" value="changeTitle"/>
            <h1>Nom</h1>
            <input type="text" name="title" placeholder="Titre de ce Gestionnaire éléctronique" value="<?php echo $gedInfo->ged_name; ?>"/>
            <br>
            <input type="submit" style="background-color: green;" value="Changer les infos"/>
        </form>
        <input class="changeComentsBtn" type="button" value="Modifier le texte de description de ce Gestionnaire éléctronique"/>
        <form action="" method="post" class="changeComents formParam">
            <input type="hidden" name="action" value="changeComents"/>
            <h1>Description</h1>
            <textarea name="content" placeholder="description"/><?php echo $gedInfo->ged_coment; ?></textarea>
            <br>
            <input type="submit" style="background-color: green;" style="background-color: green;" style="background-color: green;" style="background-color: green;" style="background-color: green;" value="Changer les infos"/>
        </form>     
    </section>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#selected-roles').select2({
                maximumSelectionLength: 1, // Définir le nombre maximum de sélections à 1
                minimumResultsForSearch:1 // Pour n'afficher aucune barre de recherche
            });
        });

    </script>
    <?php
     include("sectors/footer.php") 
    ?>
