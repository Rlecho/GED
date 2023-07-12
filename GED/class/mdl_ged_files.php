<?php
class ged_files{
    public $db;
    public $extAccepted;
    public $fileState;
    function __construct() {
        

        $this->extAccepted = array(
            "application/pdf",
            "image/jpeg",
            "image/png",
            "image/tiff",
            "text/plain", // Ajout de l'extension .txt,
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document", // Extension .docx
            "application/msword" // Extension .doc
        );
        
        require_once('mysql.php'); 
        $db = new mysqlConnector();
        $this->db = $db->dataBase;
    }
    //INSERT INTO `ged`.`ged_files` (`id`, `name`, `type`, `date`, `url`) VALUES (NULL, 'name', 'aplication/pdf', CURRENT_TIMESTAMP, 'http://sdsqqdsdsq')
    
    function copyFile($file,$category=0,$nameView=0){
        
        
        $destDir = str_replace('class\mdl_ged_files.php', 'folderRoot', __FILE__);
        $name= $file['fichier']['name'];
        $fileName=  $name;
        $type= $file['fichier']['type'];
        $tmpName= $file['fichier']['tmp_name'];
        $error= $file['fichier']['error'];
        $size= $file['fichier']['size'];
        if($this->isup($tmpName)){
            $this->fileState.="le fihier n'as pas été uploader de maniere réguilere";
            echo"le fihier n'as pas été uploader de maniere réguilere";
            die();
        }
        if(!in_array($type, $this->extAccepted)){
            
            echo'le format '.$type.' est incorecte';
            die();
        }
        if(preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $name )){
            echo'tentative de hack';
            die();
        }
        if($error !="0"){
            echo'erruer de upload';
            die();
        }
        if($size > 100000000){
            echo'erreur de taille : '.$size.' Trop lourde';
            die();
        }
        if (move_uploaded_file($tmpName, $destDir . DIRECTORY_SEPARATOR . $fileName)) {
            $baseUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
            $newUrl = $baseUrl . '/GED/folderRoot/' . $fileName;
            $this->addToDb($fileName, $type, $newUrl, $destDir . DIRECTORY_SEPARATOR . $fileName, $category, $nameView);
            $m = array("succes", "Le fichier a bien été téléchargé.");
        } else {
            $m = array("error", "Le fichier n'a pas été téléchargé.");
        }
        // header('location:dosiser.php');
    }
    
    /**
     * vérifie si le fichier à bien été chargé
    // * @param type $tmpName
     */
    function isup($tmpName){
        if(!is_uploaded_file($tmpName)){
            return true;
        }else{
            return false;
        }
    }
    
    function addToDb($fileName,$fileType,$fileUrl,$filePath,$category,$nameView){
        if($nameView==""){
            $nameView=$fileName;
        }
        $r = $this->db->prepare("INSERT INTO ged_files SET name=?, nameView=?, type=?, url=?, path=?, category_id=?");
        $r->execute([
            $fileName,
            $nameView,
            $fileType,
            $fileUrl,
            $filePath,
            $category
        ]);
    }
    public function deleteFilesByCategory($categoryId) {
        $r = $this->db->prepare("DELETE FROM ged_files WHERE category_id = ?");
        $r->execute([$categoryId]);
    }


    function getFiles(){
        $r = $this->db->prepare("SELECT * FROM ged_files order by category_id");
        $r->execute();
        return $r->fetchAll();
    }
    function getFilesByCategory($categoryId){
        $r = $this->db->prepare("SELECT * FROM ged_files WHERE category_id=? ");
        $r->execute([$categoryId]);
        return $r->fetchAll();
    }
    function getFilesByKeyWord($kw){
        $r = $this->db->prepare("SELECT * FROM ged_files WHERE name LIKE :queryString OR nameView LIKE :queryString OR keywords LIKE :queryString OR description LIKE :queryString");
        $r->execute([':queryString' => '%'.$kw.'%']);
        return $r->fetchAll();
    }
    function getTheFile($id){
        $r = $this->db->prepare("SELECT * FROM ged_files WHERE id=?");
        $r->execute([$id]);
        return $r->fetchAll()['0'];
    }
    function updateNameAndCategory($id,$name,$category,$descrition,$kw) {
        $r = $this->db->prepare("UPDATE ged_files SET nameView=?, category_id=?, description=?, keywords=? WHERE id=?");
        $r->execute([
            $name,
            $category,
            $descrition,
            $kw,
            $id
        ]);
        header('location:upload.php');
    }
}