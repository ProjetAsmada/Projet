<?php

class Securite{

    public const COOKIE_NAME="clef";
    public static function secureHTML($chaine){
        return htmlentities($chaine);
    }
    public static function estConnecte(){
        return (!empty($_SESSION['profil']));
    }
    public static function estUtilisateur(){
        return ($_SESSION['profil']['role'] === "utilisateur");
    }
    public static function estAdministrateur(){
        return ($_SESSION['profil']['role'] === "administrateur");
    }

    public static function genererCookieConnexion(){
        //double sécurisation
        $ticket = session_id().microtime().rand(0,99999);
        $ticket = hash("sha512", $ticket);
        //enregistrement dans la machine de l'utilisateur et durée
        setcookie(self::COOKIE_NAME,$ticket,time()+(60*20));
        //conservation cookie serveur
        $_SESSION['profil'][self::COOKIE_NAME] = $ticket;
    }

    public static function checkCookieConnexion(){
        //vérificiation cookie = celui stocké en variable de session
        return $_COOKIE[self::COOKIE_NAME] === $_SESSION['profil'][self::COOKIE_NAME];
    }
}