<?php
session_start();
include("sectors/header.php");
require_once('class/mdl_ged_files.php');
require_once('class/mdl_ged_categories.php');
$fileUpl = new ged_files();
$cat = new ged_categories();
// Vérifier si un dossier est spécifié
if (isset($_GET['id'])) {
    $dossierId = $_GET['id'];
    // Vérifier si le dossier existe
    $dossier = $cat->getCategory($dossierId);
    if ($dossier) {
        // Traitement du formulaire d'upload de fichier
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // $file = $_FILES['file'];
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
                            //  echo "Le fichier a été uploadé avec succès.";
                             echo "<script>alert('Le fichier a été uploadé avec succès.'); window.location.href = 'dosiser.php';</script>";
                         }           
        }
        // Afficher le formulaire d'upload de fichier
        ?>
        <form action="upload_file.php?id=<?php echo $dossierId; ?>" style="margin:5px" method="post" enctype="multipart/form-data">
            <input type="file"  name="fichier[]" multiple>
            <input type="hidden" name="category" value="<?php echo $dossierId; ?>">
            <input type="hidden" name="nameView" value="" />
            <input type="submit" style='width:150px;' value="Uploader le fichier">  
        </form>
        <?php
    } else {
        echo "Dossier introuvable.";
    }
} else {
    echo "Aucun dossier spécifié.";
}
// if(isset($_POST['action'])){
//     if($_POST['action']=="fileUpload"){
//         $table=$_FILES;
//         foreach ($table['fichier']['name'] as $key => $value) {
//             $t['fichier']['name']=$table['fichier']['name'][$key];
//             $t['fichier']['type']=$table['fichier']['type'][$key];
//             $t['fichier']['tmp_name']=$table['fichier']['tmp_name'][$key];
//             $t['fichier']['error']=$table['fichier']['error'][$key];
//             $t['fichier']['size']=$table['fichier']['size'][$key];
//             if($_POST['nameView']==""){
//                 $nameView="";
//             }else{
//                 if($key=="0"){
//                     $nameView=$_POST['nameView'];
//                 }else{
//                     $nameView=$_POST['nameView']."_".$key;
//                 }
//             }
//             $fileUpl->copyFile($t,$_POST['category'],$nameView);
//         }
//     }
?>

