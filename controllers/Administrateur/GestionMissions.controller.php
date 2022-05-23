<?php
require_once("./controllers/MainController.controller.php");
require_once("./models/Administrateur/GestionMissions.model.php");

class AdministrateurGestionMissionsController extends MainController
{
    private $administrateurGestionMissionsManager;

    public function __construct()
    {
        $this->administrateurGestionMissionsManager = new AdministrateurGestionMissionsManager();
    }
    //AFFICHER MISSIONS
    public function gestionMissions()
    {
        $missions = $this->administrateurGestionMissionsManager->bdGetMissions();

        $data_page = [
            "page_description" => "Gestion des missions",
            "page_title" => "Gestion des missions",
            "missions" => $missions,
            "view" => "views/Administrateur/gestionMissions.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

    //AJOUT MISSION
    public function ajout_mission()
    {
        $missions = $this->administrateurGestionMissionsManager->bdGetMissions();

        $data_page = [
            "page_description" => "Ajout d'une mission",
            "page_title" => "Ajout d'une mission",
            "missions" => $missions,
            "view" => "views/Administrateur/creationMission.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

    public function validation_creationMission($nom_mission, $description_mission)
    {
        if ($this->administrateurGestionMissionsManager->bdCreationMission($nom_mission, $description_mission)) {
            Toolbox::ajouterMessageAlerte("Ajout de la mission effectué", Toolbox::COULEUR_VERTE);
        } else {
            Toolbox::ajouterMessageAlerte("L'ajout de la mission n'a pas été effectué", Toolbox::COULEUR_ROUGE);
        }
        header("Location: " . URL . "administration/gestionMissions");
    }

    //SUPPRESSION MISSION
    public function suppression_mission($id_mission)
    {
        if (Securite::estAdministrateur()) {
            $this->administrateurGestionMissionsManager->bdSuppressionMission($id_mission);
            Toolbox::ajouterMessageAlerte("La suppression a été prise en compte", Toolbox::COULEUR_VERTE);
        } else {
            Toolbox::ajouterMessageAlerte("La suppression n'a pas été prise en compte", Toolbox::COULEUR_ROUGE);
        }
        header("Location: " . URL . "administration/gestionMissions");
    }

    //MODIFIER MISSION 

    public function modification_mission(){
        //var_dump(parse_url($_SERVER['REQUEST_URI']));
        $urlParse = explode("/", $_SERVER['REQUEST_URI']);
        $id_mission = end($urlParse);
        
        $mission = $this->administrateurGestionMissionsManager->getMissionById($id_mission);

        $data_page = [
            "page_description" => "Modification d'une mission",
            "page_title" => "Modification d'une mission",
            "mission" => $mission,
            "view" => "views/Administrateur/modificationMission.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }


    public function validation_modificationMission($id_mission,$nom_mission, $description_mission)
    {
        if ($this->administrateurGestionMissionsManager->bdModificationMission($id_mission,$nom_mission, $description_mission)) {
            Toolbox::ajouterMessageAlerte("La modification de la mission est effectuée", Toolbox::COULEUR_VERTE);
        } else {
            Toolbox::ajouterMessageAlerte("La modification de la mission n'a pas été effectuée", Toolbox::COULEUR_ROUGE);
        }
        header("Location: " . URL . "administration/gestionMissions");
    }

    public function pageErreur($msg)
    {
        parent::pageErreur($msg);
    }
}
