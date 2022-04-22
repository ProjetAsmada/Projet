<?php

/* 
Dans cette page on définit nos requêtes
*/

require_once "models/Model.php";
class APIManager extends Model{
    public function getDBBenevoles(){
        $req = "SELECT * 
        FROM benevole b
        INNER JOIN candidature c 
        ON b.id_benevole = c.id_benevole
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $benevoles = $stmt->fetchAll(PDO::FETCH_ASSOC);//evite deux fois les infos de nos lignes
        $stmt->closeCursor();
        return $benevoles;
    }
    public function getDBBenevole($idBenevole){
        $req = "SELECT * 
        FROM benevole b
        INNER JOIN candidature c 
        ON b.id_benevole = c.id_benevole
        WHERE b.id_benevole = :idBenevole
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idBenevole", $idBenevole,PDO::PARAM_INT);//sécurité et on attend un id en int
        $stmt->execute();
        $lignesBenevole = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $lignesBenevole;
    }
    public function getDBMissions(){
        $req = "SELECT * 
        FROM mission m
        INNER JOIN candidature c 
        ON m.id_mission = c.id_mission
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $missions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $missions;
    }
    public function getDBMission($idMission){
        $req = "SELECT * 
        FROM mission m
        INNER JOIN candidature c 
        ON m.id_mission = c.id_mission
        WHERE m.id_mission = :idMission
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idMission", $idMission,PDO::PARAM_INT);
        $stmt->execute();
        $lignesMission = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $lignesMission;
    }
    public function getDBCandidatures(){
        $req = "SELECT * 
        FROM candidature c
        INNER JOIN benevole b 
        ON c.id_benevole = b.id_benevole
        INNER JOIN mission m 
        ON c.id_mission = m.id_mission
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $candidatures = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $candidatures;
    }
    public function getDBCandidature($idBenevole, $idMission){
        $req = "SELECT * 
        FROM candidature c
        INNER JOIN benevole b 
        ON c.id_benevole = b.id_benevole
        INNER JOIN mission m 
        ON c.id_mission = m.id_mission
        WHERE c.id_mission = :idMission
        AND c.id_benevole = :idBenevole
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idMission", $idMission,PDO::PARAM_INT);
        $stmt->bindValue(":idBenevole", $idBenevole,PDO::PARAM_INT);
        $stmt->execute();
        $lignesCandidature = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $lignesCandidature;
    }
}