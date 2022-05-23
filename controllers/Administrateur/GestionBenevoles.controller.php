<?php
require_once("./controllers/MainController.controller.php");
require_once("./models/Administrateur/GestionBenevoles.model.php");

class AdministrateurGestionBenevolesController extends MainController
{
    private $administrateurGestionBenevolesManager;

    public function __construct()
    {
        $this->administrateurGestionBenevolesManager = new AdministrateurGestionBenevolesManager();
    }

    //AFFICHAGE DES BENEVOLES
    public function gestionBenevoles()
    {
        $utilisateurs = $this->administrateurGestionBenevolesManager->getUtilisateurs();

        $data_page = [
            "page_description" => "Gestion des droits",
            "page_title" => "Gestion des droits",
            "utilisateurs" => $utilisateurs,
            "view" => "views/Administrateur/gestionBenevoles.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

    //AJOUT D'UN BENEVOLE
    public function ajout_utilisateur()
    {
        $utilisateurs = $this->administrateurGestionBenevolesManager->getUtilisateurs();

        $data_page = [
            "page_description" => "Ajout d'un utilisateur",
            "page_title" => "Ajout d'un utilisateur",
            "utilisateurs" => $utilisateurs,
            "view" => "views/Administrateur/creationBenevole.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

    public function validation_creationBenevole($login, $password, $mail, $est_valide, $role)
    {
        if ($this->administrateurGestionBenevolesManager->verifLoginDisponible($login)) {
            $passwordCrypte = password_hash($password, PASSWORD_DEFAULT);
            if ($this->administrateurGestionBenevolesManager->bdCreationBenevole($login, $passwordCrypte, $mail, $est_valide, $role)) {
                Toolbox::ajouterMessageAlerte("Ajout effectué", Toolbox::COULEUR_VERTE);
            } else {
                Toolbox::ajouterMessageAlerte("L'ajout n'a pas été effectué", Toolbox::COULEUR_ROUGE);
            }
            header("Location: " . URL . "administration/gestionBenevoles");
        } else {
            Toolbox::ajouterMessageAlerte("Le login est déjà utilisé !", Toolbox::COULEUR_ROUGE);
            header("Location: " . URL . "administration/gestionBenevoles");
        }
    }

    //SUPPRESSION BENEVOLE
    public function suppression_utilisateur($login)
    {
        if ($this->administrateurGestionBenevolesManager->bdSuppressionUtilisateur($login)) {
            Toolbox::ajouterMessageAlerte("La suppression a été prise en compte", Toolbox::COULEUR_VERTE);
        } else {
            Toolbox::ajouterMessageAlerte("La suppression n'a pas été prise en compte", Toolbox::COULEUR_ROUGE);
        }
        header("Location: " . URL . "administration/gestionBenevoles");
    }

    //MODIFICATION BENEVOLE
    public function validation_modificationRole($login, $role)
    {
        if ($this->administrateurGestionBenevolesManager->bdModificationRoleUser($login, $role)) {
            Toolbox::ajouterMessageAlerte("La modification a été prise en compte", Toolbox::COULEUR_VERTE);
        } else {
            Toolbox::ajouterMessageAlerte("La modification n'a pas été prise en compte", Toolbox::COULEUR_ROUGE);
        }
        header("Location: " . URL . "administration/gestionBenevoles");
    }

    public function validation_modificationValidationCompte($login, $est_valide)
    {
        if ($this->administrateurGestionBenevolesManager->bdModificationValidationCompteUser($login, $est_valide)) {
            Toolbox::ajouterMessageAlerte("La modification a été prise en compte", Toolbox::COULEUR_VERTE);
        } else {
            Toolbox::ajouterMessageAlerte("La modification n'a pas été prise en compte", Toolbox::COULEUR_ROUGE);
        }
        header("Location: " . URL . "administration/gestionBenevoles");
    }
}