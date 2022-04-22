<?php

/*
ici on définit nos urls et le routage 
*/

session_start();

define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

require_once "controllers/front/API.controller.php";
$apiController = new APIController();

require_once "controllers/back/admin.controller.php";
$adminController = new AdminController();

try {
    if (empty($_GET['page'])) {
        throw new Exception("La page n'existe pas");
    }
    else {
        $url = explode("/",filter_var($_GET['page'], FILTER_SANITIZE_URL));
        if(empty($url[0]) || empty($url[1])) throw new Exception("La page n'existe pas");
            switch($url[0]){
            case "front" : 
                switch($url[1]){
                    case "benevoles": $apiController ->getAllBenevoles();
                    break;
                    case "benevole": 
                        if(empty($url[2])) throw new Exception("id bénévole manquant");
                        $apiController ->getBenevole($url[2]);
                    break;
                    case "missions": $apiController ->getAllMissions();
                    break;
                    case "mission": 
                        if(empty($url[2])) throw new Exception("id mission manquant");
                        $apiController ->getMission($url[2]);
                    break;
                    case "candidatures": $apiController ->getAllCandidatures();
                    break;
                    case "candidature": 
                        if(empty($url[2]) || empty($url[3])) throw new Exception("id bénévole ou mission manquant");
                        $apiController ->getCandidature($url[2], $url[3]);
                    break;
                    default : throw new Exception("La page n'existe pas");
                }
                break;
            case "back" : 
                switch($url[1]){
                    case "login" : $adminController->getPageLogin();
                    break;
                    case "connexion" : $adminController->connexion();
                    break;
                    case "connexion-admin" : $adminController->connexionAdmin();
                    break;
                    case "admin" : $adminController->getAccueilAdmin();
                    break;
                    case "connexion-benevole" : $adminController->connexionBenevole();
                    break;
                    case "benevole" : $adminController->getAccueilBenevole();
                    break;
                    default : throw new Exception("La page n'existe pas");
                }
            break;
            default : throw new Exception("La page n'existe pas");
        }
    }
} catch (Exception $e) {
    $msg = $e->getMessage();
    echo $msg;
}
