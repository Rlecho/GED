<?php
class ged_trash{
    public $db;
    function __construct() {
        require_once('mysql.php'); 
        $db = new mysqlConnector();
        $this->db = $db->dataBase;
    }
    function moveToTrash($id){
        $r = $this->db->prepare("SELECT * FROM ged_files WHERE id = ?");
        $r->execute([$id]);
        $n = $r->fetchAll();
        if(isset($n[0])){
          $n = $n[0];
          $s = serialize($n);
          if(isset($n->nameView)){
            $name = $n->nameView;
            $r = $this->db->prepare("INSERT INTO ged_trash SET file_name=?, data=?");
            $r->execute([$name, $s]);
          }else{
            // Gérer le cas où la propriété nameView est manquante
          }
          $r = $this->db->prepare("DELETE FROM ged_files WHERE id=?");
          $r->execute([$id]);
          unserialize($s);
        }else{
          // Gérer le cas où aucun fichier n'a été trouvé
        }
    }
    function getAllTrash(){
        $r = $this->db->prepare("SELECT * FROM ged_trash");
        $r->execute();
        return $r->fetchAll();
    }
    function unlinkFile($trashId){
        $r = $this->db->prepare("SELECT * FROM ged_trash WHERE id = ?");
        $r->execute([$trashId]);
        $n = $r->fetchAll();
        if(isset($n[0])){
          $n = $n[0];
          $o = unserialize($n->data);
          if(isset($o->path)){
            unlink($o->path);
          }else{
            // Gérer le cas où la propriété path est manquante
          }
          $rb = $this->db->prepare("DELETE FROM ged_trash WHERE id=?");
          $rb->execute([$trashId]);
          $ra = $this->db->prepare("DELETE FROM ged_files_as_tags WHERE file_id=?");
          $ra->execute([$o->id]);
        }else{
          // Gérer le cas où aucun fichier n'a été trouvé dans la corbeille
        }
    }
    function backFile($trashId){
        $r = $this->db->prepare("SELECT * FROM ged_trash WHERE id = ?");
        $r->execute([$trashId]);
        $n = $r->fetchAll();
        if(isset($n[0])){
          $n = $n[0];
          $o = unserialize($n->data);
          $r = $this->db->prepare("INSERT INTO ged_files SET id=?, name=?, nameView=?, type=?, date=?, url=?, path=?, category_id=?, author=?, size=?, description=?, keywords=?, version=?, metaData=?");
          $r->execute([
              $o->id,
              $o->name,
              $o->nameView,
              $o->type,
              $o->date,
              $o->url,
              $o->path,
              $o->category_id,
              $o->author,
              $o->size,
              $o->description,
              $o->keywords,
              $o->version,
              $o->metaData
          ]);
          $rb = $this->db->prepare("DELETE FROM ged_trash WHERE id=?");
          $rb->execute([$trashId]);
        }else{
          // Gérer le cas où aucun fichier n'a été trouvé dans la corbeille
        }
    }
}
?>