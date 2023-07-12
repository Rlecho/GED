<?php 
class Dossier {
    public $id;
    public $name;
    public $date_arrivee;
    public $description;
    public $author;
    public $refer;
    public $id_tag;
    public $role;
    
    public function __construct($row) {
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->date_arrivee = $row['date_arrivee'];
        $this->description = $row['description'];
        $this->author = $row['author'];
        $this->refer = $row['refer'];
        $this->id_tag = $row['id_tag'];
        $this->role = $row['role'];
    }
    
    // Ajoutez d'autres propriétés ou méthodes nécessaires
}

?>