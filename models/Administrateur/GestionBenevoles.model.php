<?php 
require_once("./models/MainManager.model.php");

class AdministrateurGestionBenevolesManager extends MainManager{

    //AFFICHAGE DES UTILISATEURS
    public function getUtilisateurs(){
        $req = $this->getBdd()->prepare("SELECT * FROM utilisateur WHERE role ='utilisateur'");
        $req->execute();
        $datas = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $datas;
    }

    //CREATION D'UN NOUVEL UTILISATEUR
    public function bdCreationBenevole($login,$passwordCrypte,$mail,$est_valide,$role){
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

    //UTILE POUR LA FONCTION DE VERIFICATION DU LOGIN LORS DE LA CREATION D'UN NOUVEL UTILISATEUR
    public function getUserInformation($login){
        $req = "SELECT * FROM utilisateur WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->execute();
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $resultat;
    }

    //IDEM UTILE POUR CREATION UTILISATEUR
    public function verifLoginDisponible($login){
        $utilisateur = $this->getUserInformation($login);
        return empty($utilisateur);
    }

    //SUPPRESSION D'UN UTILISATEUR
    public function bdSuppressionUtilisateur($login){
        $req = "DELETE from utilisateur WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->execute();
        $estModifier = ($stmt->rowCount() > 0);
        $stmt->closeCursor();
        return $estModifier;
    }

    //MODIFICATION ROLE UTILISATEUR (UTILISATEUR OU ADMIN)
    public function bdModificationRoleUser($login,$role){
        $req = "UPDATE utilisateur SET role = :role WHERE login = :login";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->bindValue(":role",$role,PDO::PARAM_STR);
        $stmt->execute();
        $estModifier = ($stmt->rowCount() > 0);
        $stmt->closeCursor();
        return $estModifier;
    }

    //MODIFICATION DU STATUT DU COMPTE : VALIDE OU NON
    public function bdModificationValidationCompteUser($login,$est_valide){
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