<?php

/* 
Dans cette page on appelle les requêtes définies dans API.manager.php 
pour que l'admin puisse effectuer les opérations CRUD de base
*/

require_once "models/front/API.manager.php";
require_once "models/Model.php";
class APIController{
    private $apiManager;
    public function __construct(){
        $this->apiManager = new APIManager();
    }
    
    //*** CREATE BENEVOLES MISSIONS CANDIDATURES ***//

    //*** READ BENEVOLES MISSIONS CANDIDATURES ***//
    public function getAllBenevoles(){
        $benevoles = $this->apiManager->getDBBenevoles();
        Model::sendJson($this->formatDataLignesBenevoles($benevoles));
    }
    public function getBenevole($idBenevole){
        $lignesBenevole = $this->apiManager->getDBBenevole($idBenevole);
        Model::sendJson($this->formatDataLignesBenevoles($lignesBenevole));
    }
    public function getAllMissions(){
        $missions = $this->apiManager->getDBMissions();
        Model::sendJson($this->formatDataLignesMissions($missions));
    }
    public function getMission($idMission){
        $lignesMission = $this->apiManager->getDBMission($idMission);
        Model::sendJson($this->formatDataLignesMissions($lignesMission));
    }
    public function getAllCandidatures(){
        $candidatures = $this->apiManager->getDBCandidatures();
        Model::sendJson($this->formatDataLignesCandidature($candidatures));
    }
    public function getCandidature($idBenevole, $idMission){
        $lignesCandidature = $this->apiManager->getDBCandidature($idBenevole,$idMission);
        Model::sendJson($this->formatDataLignesCandidature($lignesCandidature));
    }

    //*** UPDATE BENEVOLES MISSIONS CANDIDATURES ***//

    //*** DELETE BENEVOLES MISSIONS CANDIDATURES ***//
    private function formatDataLignesBenevoles($lignes){
        $tab = [];
        foreach($lignes as $ligne){
        if(!array_key_exists($ligne['id_benevole'],$tab)){
            $tab[$ligne['id_benevole']]=[
                "id" => $ligne['id_benevole'],
                "nom" => $ligne['nom_benevole'],
                "prenom" => $ligne['prenom_benevole'],
                "date naissance" => $ligne['date_naissance_benevole'],
                "email" => $ligne['email_benevole'],
                "adresse" => $ligne['adresse_benevole'],
                "telephone" => $ligne['telephone_benevole'],
                "début disponibilité" => $ligne['debut_disponibilite_benevole'],
                "fin disponibilité" => $ligne['fin_disponibilite_benevole'],
                "profession" => $ligne['profession_benevole'],
                "description" => $ligne['description_benevole']
            ];
            }   
        }
        echo "<pre>";
        print_r($tab);
        echo "</pre>";
    }

    //*** FONCTIONS POUR FORMATER LES DATAS AFFICHEES ***//
    private function formatDataLignesMissions($lignes){
        $tab = [];
        foreach($lignes as $ligne){
        if(!array_key_exists($ligne['id_mission'],$tab)){
            $tab[$ligne['id_mission']]=[
                "id" => $ligne['id_mission'],
                "nom" => $ligne['nom_mission'],
                "localisation" => $ligne['localisation_mission'],
                "durée" => $ligne['duree_mission'],
                "réussite" => $ligne['reussite_mission'],
                "description" => $ligne['description_mission']
            ];
            }   
        }
        echo "<pre>";
        print_r($tab);
        echo "</pre>";
    }

    private function formatDataLignesCandidature($lignes){
        $tab = [];
        foreach($lignes as $ligne){
        //if(!array_key_exists($ligne['id_mission'],$tab)){
            $tab[$ligne['id_mission']]=[
                "id de la mission" => $ligne['id_mission'],
                "id du benevole" => $ligne['id_benevole']
            ];  
        }
        echo "<pre>";
        print_r($tab);
        echo "</pre>";
    }
}
