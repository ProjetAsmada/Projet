<?php
require_once("./models/MainManager.model.php");

class AdministrateurGestionCandidaturesManager extends MainManager
{
//AFFICHER LES CANDIDATURES

    public function bdGetCandidatures(){
        $req = $this->getBdd()->prepare("SELECT * FROM candidature INNER JOIN utilisateur ON candidature.id_benevole = utilisateur.login INNER JOIN mission ON candidature.id_mission = mission.id_mission");

        $req->execute();
        $datas = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $datas;
    }
}