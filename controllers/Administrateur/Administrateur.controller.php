<?php
require_once("./controllers/MainController.controller.php");
require_once("./models/Administrateur/Administrateur.model.php");

class AdministrateurController extends MainController
{
    private $administrateurManager;

    public function __construct()
    {
        $this->administrateurManager = new AdministrateurManager();
    }

    //*** GESTION MISSIONS ***//
    public function gestionMissions()
    {
        $missions = $this->administrateurManager->bdGetMissions();

        $data_page = [
            "page_description" => "Gestion des missions",
            "page_title" => "Gestion des missions",
            "missions" => $missions,
            "view" => "views/Administrateur/gestionMissions.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

    //*** GESTION ADMINISTRATEURS ***//
    public function gestionAdministrateurs()
    {
        $administrateurs = $this->administrateurManager->bdGetAdministrateurs();

        $data_page = [
            "page_description" => "Gestion des administrateurs",
            "page_title" => "Gestion des administrateurs",
            "administrateurs" => $administrateurs,
            "view" => "views/Administrateur/gestionAdministrateurs.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

    public function pageErreur($msg)
    {
        parent::pageErreur($msg);
    }
}