<?php 
require_once("./models/MainManager.model.php");

class AdministrateurManager extends MainManager{
    public function getUtilisateurs(){
        $req = $this->getBdd()->prepare("SELECT * FROM utilisateur WHERE role ='utilisateur'");
        $req->execute();
        $datas = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $datas;
    }

    

    //*** REQUETES POUR LA MISSION ***//
    // !!! pour création utiliser return $this->getBdd()->lastInsertId(); !!!
    //et dans le controller $idMission = this->manager->createmission(...)
    public function bdGetMissions(){
            $req = "SELECT * from mission";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->execute();
            $missions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $missions;
        }

    //*** REQUETES POUR LES ADMINISTRATEURS ***//
    public function bdGetAdministrateurs(){
        $req = $this->getBdd()->prepare("SELECT * FROM utilisateur WHERE role ='administrateur'");
        $req->execute();
        $datas = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $datas;
    }
}