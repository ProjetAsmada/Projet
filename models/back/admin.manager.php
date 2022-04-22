<?php

require_once "./models/Model.php";

class AdminManager extends Model{
    
    private function getPasswordUser($login){
        $req= 'SELECT * FROM administration WHERE login = :login';
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $admin['password'];
    }

    public function isConnexionValid($login,$password){
        $passwordBD = $this->getPasswordUser($login);
        return password_verify($password,$passwordBD);
    }
    
    private function getAdminPasswordUser($login){
        $req= 'SELECT * FROM administration WHERE login = :login';
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $admin['password'];
    }

    public function isAdminConnexionValid($login,$password){
        $passwordBD = $this->getAdminPasswordUser($login);
        return password_verify($password,$passwordBD);
    }

    private function getBenevolePasswordUser($login){
        $req= 'SELECT * FROM benevole WHERE login = :login';
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $admin['password'];
    }

    public function isBenevoleConnexionValid($login,$password){
        $passwordBD = $this->getBenevolePasswordUser($login);
        return password_verify($password,$passwordBD);
    }
}

?>