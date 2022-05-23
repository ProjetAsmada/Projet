<?php
require_once("./controllers/MainController.controller.php");
require_once("./models/Administrateur/GestionAdministrateurs.model.php");

class AdministrateurGestionAdministrateursController extends MainController
{
    private $administrateurGestionAdministrateursManager;

    public function __construct()
    {
        $this->administrateurGestionAdministrateursManager = new AdministrateurGestionAdministrateursManager();
    }

    //AFFICHAGE DES ADMINISTRATEURS
    public function gestionAdministrateurs()
    {
        $administrateurs = $this->administrateurGestionAdministrateursManager->getAdministrateurs();

        $data_page = [
            "page_description" => "Gestion des administrateurs",
            "page_title" => "Gestion des administrateurs",
            "administrateurs" => $administrateurs,
            "view" => "views/Administrateur/gestionAdministrateurs.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

    //AJOUT D'UN ADMINISTRATEUR
    public function ajout_administrateur()
    {
        $administrateurs = $this->administrateurGestionAdministrateursManager->getAdministrateurs();

        $data_page = [
            "page_description" => "Ajout d'un utilisateur",
            "page_title" => "Ajout d'un utilisateur",
            "administrateurs" => $administrateurs,
            "view" => "views/Administrateur/creationAdministrateur.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

    public function validation_creationAdministrateur($login, $password, $mail, $est_valide, $role)
    {
        if ($this->administrateurGestionAdministrateursManager->verifLoginDisponible($login)) {
            $passwordCrypte = password_hash($password, PASSWORD_DEFAULT);
            if ($this->administrateurGestionAdministrateursManager->bdCreationAdministrateur($login, $passwordCrypte, $mail, $est_valide, $role)) {
                Toolbox::ajouterMessageAlerte("Ajout de l'administrateur effectué", Toolbox::COULEUR_VERTE);
            } else {
                Toolbox::ajouterMessageAlerte("L'ajout de l'administrateur n'a pas été effectué", Toolbox::COULEUR_ROUGE);
            }
            header("Location: " . URL . "administration/gestionAdministrateurs");
        } else {
            Toolbox::ajouterMessageAlerte("Le login est déjà utilisé !", Toolbox::COULEUR_ROUGE);
            header("Location: " . URL . "administration/gestionAdministrateurs");
        }
    }

    //SUPPRESSION ADMINISTRATEUR
    public function suppression_administrateur($login)
    {
        if ($this->administrateurGestionAdministrateursManager->bdSuppressionAdministrateur($login)) {
            Toolbox::ajouterMessageAlerte("La suppression a été prise en compte", Toolbox::COULEUR_VERTE);
        } else {
            Toolbox::ajouterMessageAlerte("La suppression n'a pas été prise en compte", Toolbox::COULEUR_ROUGE);
        }
        header("Location: " . URL . "administration/gestionAdministrateurs");
    }

    //MODIFICATION ADMINISTRATEUR
    public function validation_modificationRoleAdministrateur($login, $role)
    {
        if ($this->administrateurGestionAdministrateursManager->bdModificationRoleAdministrateur($login, $role)) {
            Toolbox::ajouterMessageAlerte("La modification a été prise en compte", Toolbox::COULEUR_VERTE);
        } else {
            Toolbox::ajouterMessageAlerte("La modification n'a pas été prise en compte", Toolbox::COULEUR_ROUGE);
        }
        header("Location: " . URL . "administration/gestionAdministrateurs");
    }

    public function validation_modificationValidationCompteAdministrateur($login, $est_valide)
    {
        if ($this->administrateurGestionAdministrateursManager->bdModificationValidationCompteAdministrateur($login, $est_valide)) {
            Toolbox::ajouterMessageAlerte("La modification a été prise en compte", Toolbox::COULEUR_VERTE);
        } else {
            Toolbox::ajouterMessageAlerte("La modification n'a pas été prise en compte", Toolbox::COULEUR_ROUGE);
        }
        header("Location: " . URL . "administration/gestionAdministrateurs");
    }
}