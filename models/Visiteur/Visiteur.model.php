<?php 
require_once("./models/MainManager.model.php");

class VisiteurManager extends MainManager{
 
    public function getMissions(){
        $req = $this->getBdd()->prepare("SELECT * FROM mission");
        $req->execute();
        $datas = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $datas;
    }
}