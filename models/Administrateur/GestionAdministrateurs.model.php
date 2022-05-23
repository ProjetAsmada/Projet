<?php 
require_once("./models/MainManager.model.php");

class AdministrateurGestionAdministrateursManager extends MainManager{
    public function getAdministrateurs(){
        $req = $this->getBdd()->prepare("SELECT * FROM utilisateur WHERE role ='administrateur'");
        $req->execute();
        $datas = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $datas;
    }


    //CREATION D'UN NOUVEL ADMINISTRATEUR
    public function bdCreationAdministrateur($login,$passwordCrypte,$mail,$est_valide,$role){
        $req = "INSERT INTO utilisateur (login,password,mail,est_valide,role) 
        VALUES (:login,:password,:mail,:est_valide,:role)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->bindValue(":password",$passwordCrypte,PDO::PARAM_STR);
        $stmt->bindValue(":mail",$mail,PDO::PARAM_STR);
        $stmt->bindValue(":est_valide",$est_valide,PDO::PARAM_BOOL);
        $stmt->bindValue(":role",$role,PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
        $estModifier = ($stmt->rowCount() > 0);
        $stmt->closeCursor();
        return $estModifier;
    }

    //UTILE POUR LA FONCTION DE VERIFICATION DU LOGIN LORS DE LA CREATION D'UN NOUVEL ADMINISTRATEUR
    public function getAdminInformation($login){
        $req = "SELECT * FROM utilisateur WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->execute();
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $resultat;
    }

    //IDEM UTILE POUR CREATION ADMINISTRATEUR
    public function verifLoginDisponible($login){
        $administrateur = $this->getAdminInformation($login);
        return empty($administrateur);
    }

    //SUPPRESSION D'UN ADMINISTRATEUR
    public function bdSuppressionAdministrateur($login){
        $req = "DELETE from utilisateur WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->execute();
        $estModifier = ($stmt->rowCount() > 0);
        $stmt->closeCursor();
        return $estModifier;
    }
    //MODIFICATION ROLE ADMINISTRATEUR (RETROGRADAGE)
    public function bdModificationRoleAdministrateur($login,$role){
        $req = "UPDATE utilisateur SET role = :role WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->bindValue(":role",$role,PDO::PARAM_STR);
        $stmt->execute();
        $estModifier = ($stmt->rowCount() > 0);
        $stmt->closeCursor();
        return $estModifier;
    }

    //MODIFICATION DU STATUT DU COMPTE ADMIN: VALIDE OU NON
    public function bdModificationValidationCompteAdministrateur($login,$est_valide){
        $req = "UPDATE utilisateur SET est_valide = :est_valide WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->bindValue(":est_valide",$est_valide,PDO::PARAM_BOOL);
        $stmt->execute();
        $estModifier = ($stmt->rowCount() > 0);
        $stmt->closeCursor();
        return $estModifier;
    }
}