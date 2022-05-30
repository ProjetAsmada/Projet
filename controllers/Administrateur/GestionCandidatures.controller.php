<?php
require_once("./controllers/MainController.controller.php");
require_once("./models/Administrateur/GestionCandidatures.model.php");

class AdministrateurGestionCandidaturesController extends MainController
{
    private $administrateurGestionMissionsManager;

    public function __construct()
    {
        $this->administrateurGestionCandidaturesManager = new AdministrateurGestionCandidaturesManager();
    }
    //AFFICHER CANDIDATURES
    public function gestionCandidatures(){

        $candidatures = $this->administrateurGestionCandidaturesManager->bdGetCandidatures();
    
        $data_page = [
            "page_description" => "Gestion des candidatures",
            "page_title" => "Gestion des candidatures",
            "candidatures" => $candidatures,
            "view" => "views/Administrateur/gestionCandidatures.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

}

