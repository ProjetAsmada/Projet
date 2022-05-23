<?php
require_once("./models/MainManager.model.php");

class AdministrateurGestionMissionsManager extends MainManager
{

    //*** REQUETES POUR LA MISSION ***//
    // !!! pour création utiliser return $this->getBdd()->lastInsertId(); !!!
    //et dans le controller $idMission = this->manager->createmission(...)
    public function bdGetMissions()
    {
        $req = "SELECT * from mission";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $missions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $missions;
    }

    //CREATION D'UNE NOUVELLE MISSION
    public function bdCreationMission($nom_mission,$description_mission){
        $req = "INSERT INTO mission (nom_mission,description_mission) 
        VALUES (:nom_mission,:description_mission)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":nom_mission",$nom_mission,PDO::PARAM_STR);
        $stmt->bindValue(":description_mission",$description_mission,PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
        //$estModifier = ($stmt->rowCount() > 0);
        //$stmt->closeCursor();
        //return $estModifier;
        return $this->getBdd()->lastInsertId();//récup de l'id qui est AI
    }

    //SUPPRESSION D'UNE MISSION
    public function bdSuppressionMission($id_mission){
        $req = "DELETE from mission WHERE id_mission = :id_mission";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id_mission",$id_mission,PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    //MODIFICATION MISSION
    public function bdModificationMission($id_mission,$nom_mission,$description_mission){
        $req ="UPDATE mission SET nom_mission = :nom_mission, description_mission = :description_mission
        WHERE id_mission= :id_mission";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id_mission",$id_mission,PDO::PARAM_INT);
        $stmt->bindValue(":nom_mission",$nom_mission,PDO::PARAM_STR);
        $stmt->bindValue(":description_mission",$description_mission,PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function getMissionById($id_mission){
        $req ="SELECT * FROM mission WHERE id_mission = :id_mission";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id_mission",$id_mission,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
}
