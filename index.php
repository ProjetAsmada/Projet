<?php
session_start();

define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") .
    "://" . $_SERVER['HTTP_HOST'] . $_SERVER["PHP_SELF"]));

require_once("./utils/Toolbox.class.php");
require_once("./utils/Securite.class.php");
require_once("./controllers/Visiteur/Visiteur.controller.php");
require_once("./controllers/Utilisateur/Utilisateur.controller.php");
require_once("./controllers/Administrateur/Administrateur.controller.php");
require_once("./controllers/Administrateur/GestionBenevoles.controller.php");
require_once("./controllers/Administrateur/GestionAdministrateurs.controller.php");
require_once("./controllers/Administrateur/GestionMissions.controller.php");
require_once("./controllers/Administrateur/GestionCandidatures.controller.php");

$visiteurController = new VisiteurController();
$utilisateurController = new UtilisateurController();
$administrateurController = new AdministrateurController();

$administrateurGestionBenevolesController = new AdministrateurGestionBenevolesController();
$administrateurGestionAdministrateursController = new AdministrateurGestionAdministrateursController();
$administrateurGestionMissionsController = new AdministrateurGestionMissionsController();
$administrateurGestionCandidaturesController = new AdministrateurGestionCandidaturesController();

try {
    if (empty($_GET['page'])) {
        $page = "accueil";
    } else {
        $url = explode("/", filter_var($_GET['page'], FILTER_SANITIZE_URL));
        $page = $url[0];
    }

    //***DIFFERENTS CAS POUR UTILISATEURS***//
    /**
     * il est donc connecté
     * il peut consulter son profil
     * il peut se déconnecter
     * il peut modifier son email
     * il peut modifier son password
     * il peut supprimer son compte
     * il peut upload une image
     * il peut upload un cv
     * il peut postuler à une offre 
     * il peut répondre à un qcm pour se noter
     * il peut répondre à un qcm pour un admin
     */
    switch ($page) {
        case "accueil":
            $visiteurController->accueil();
            break;
        case "missions":
            $visiteurController->missionsConsultation();
            break;
        case "login":
            $visiteurController->login();
            break;
        case "validation_login":
            if (!empty($_POST['login']) && !empty($_POST['password'])) {
                $login = Securite::secureHTML($_POST['login']);
                $password = Securite::secureHTML($_POST['password']);
                $utilisateurController->validation_login($login, $password);
            } else {
                Toolbox::ajouterMessageAlerte("Login ou mot de passe non renseigné", Toolbox::COULEUR_ROUGE);
                header('Location: ' . URL . "login");
            }
            break;
        case "creerCompte":
            $visiteurController->creerCompte();
            break;
        case "validation_creerCompte":
            if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['mail'])) {
                $login = Securite::secureHTML($_POST['login']);
                $password = Securite::secureHTML($_POST['password']);
                $mail = Securite::secureHTML($_POST['mail']);
                $prenom = Securite::secureHTML($_POST['prenom']);
                $nom = Securite::secureHTML($_POST['nom']);
                $telephone = Securite::secureHTML($_POST['telephone']);
                $utilisateurController->validation_creerCompte($login, $password, $mail, $prenom, $nom, $telephone);
            } else {
                Toolbox::ajouterMessageAlerte("Les informations sont obligatoires !", Toolbox::COULEUR_ROUGE);
                header("Location: " . URL . "creerCompte");
            }
            break;
        case "renvoyerMailValidation":
            $utilisateurController->renvoyerMailValidation($url[1]);
            break;
        case "validationMail":
            $utilisateurController->validation_mailCompte($url[1], $url[2]);
            break;
        case "compte":
            if (!Securite::estConnecte()) {
                Toolbox::ajouterMessageAlerte("Veuillez vous connecter !", Toolbox::COULEUR_ROUGE);
                header("Location: " . URL . "login");
            } elseif (!Securite::checkCookieConnexion()) {
                Toolbox::ajouterMessageAlerte("Veuillez vous reconnecter !", Toolbox::COULEUR_ROUGE);
                //suppression de la session user
                setCookie(Securite::COOKIE_NAME, "", time() - 3600);
                unset($_SESSION["profil"]);
                header("Location: " . URL . "login");
            } else {
                Securite::genererCookieConnexion(); //regénération cookie si +20min
                switch ($url[1]) {
                    case "profil":
                        $utilisateurController->profil();
                        break;
                    case "deconnexion":
                        $utilisateurController->deconnexion();
                        break;
                    case "validation_modificationMail":
                        $utilisateurController->validation_modificationMail(Securite::secureHTML($_POST['mail']));
                        break;
                    case "modificationPassword":
                        $utilisateurController->modificationPassword();
                        break;
                    case "validation_modificationPassword":
                        if (!empty($_POST['ancienPassword']) && !empty($_POST['nouveauPassword']) && !empty($_POST['confirmNouveauPassword'])) {
                            $ancienPassword = Securite::secureHTML($_POST['ancienPassword']);
                            $nouveauPassword = Securite::secureHTML($_POST['nouveauPassword']);
                            $confirmationNouveauPassword = Securite::secureHTML($_POST['confirmNouveauPassword']);
                            $utilisateurController->validation_modificationPassword($ancienPassword, $nouveauPassword, $confirmationNouveauPassword);
                        } else {
                            Toolbox::ajouterMessageAlerte("Vous n'avez pas renseigné toutes les informations", Toolbox::COULEUR_ROUGE);
                            header("Location: " . URL . "compte/modificationPassword");
                        }
                        break;
                    case "suppressionCompte":
                        $utilisateurController->suppressionCompte();
                        break;
                    case "validation_modificationImage":
                        if ($_FILES['image']['size'] > 0) {
                            $utilisateurController->validation_modificationImage($_FILES['image']);
                        } else {
                            Toolbox::ajouterMessageAlerte("Vous n'avez pas modifié l'image", Toolbox::COULEUR_ROUGE);
                            header("Location: " . URL . "compte/profil");
                        }
                        break;
                    case "missions":
                        $utilisateurController->missions();
                        break;
                    case "candidature":
                        $utilisateurController->candidater();
                        break;
                    case "mesCandidatures":
                        $utilisateurController->historiqueCandidatures();
                        break;
                    default:
                        throw new Exception("La page n'existe pas");
                }
            }
            break;

            //***DIFFERENTS CAS POUR L'ADMIN***//
            /**
             * il peut se connecter
             * il peut se deconnecter
             * il peut consulter son profil
             * il peut voir, modifier, supprimer les infos des bénévoles
             * il peut voir les autres admin
             * il peut consulter les candidatures
             * il peut répondre à une candidature
             * il peut voir, modifier, supprimer les candidatures
             */
        case "administration":
            if (!Securite::estConnecte()) {
                Toolbox::ajouterMessageAlerte("Veuillez vous connecter !", Toolbox::COULEUR_ROUGE);
                header("Location: " . URL . "Login");
            } elseif (!Securite::estAdministrateur()) {
                Toolbox::ajouterMessageAlerte("Vous n'avez le droit d'être ici", Toolbox::COULEUR_ROUGE);
                header("Location: " . URL . "accueil");
            } else {
                switch ($url[1]) {
                        //afficher bénévoles
                    case "gestionBenevoles":
                        $administrateurGestionBenevolesController->gestionBenevoles();
                        break;
                        //modifier infos bénévole (role et validation compte) 
                    case "validation_modificationRole":
                        $administrateurGestionBenevolesController->validation_modificationRole($_POST['login'], $_POST['role']);
                        break;
                    case "validation_modificationValidationCompte":
                        $administrateurGestionBenevolesController->validation_modificationValidationCompte($_POST['login'], $_POST['est_valide']);
                        break;
                        //supprimer bénévole
                    case "suppression_utilisateur":
                        $administrateurGestionBenevolesController->suppression_utilisateur($_POST['login']);
                        break;
                        //ajouter bénévole
                    case "ajout_utilisateur":
                        $administrateurGestionBenevolesController->ajout_utilisateur();
                        break;
                    case "validation_creationBenevole":
                        if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['mail'] && preg_match('#^[a-zA-Z0-9]*$#', $_POST['login']))) {
                            $login = Securite::secureHTML($_POST['login']);
                            $password = Securite::secureHTML($_POST['password']);
                            $mail = Securite::secureHTML($_POST['mail']);
                            $est_valide = Securite::secureHTML($_POST['est_valide']);
                            $role = Securite::secureHTML($_POST['role']);
                            $prenom = Securite::secureHTML($_POST['prenom']);
                            $nom = Securite::secureHTML($_POST['nom']);
                            $telephone = Securite::secureHTML($_POST['telephone']);
                            $administrateurGestionBenevolesController->validation_creationBenevole($login, $password, $mail, $est_valide, $role, $prenom, $nom, $telephone);
                        } else {
                            Toolbox::ajouterMessageAlerte("Il manque une information ou un caractère interdit a été saisi", Toolbox::COULEUR_ROUGE);
                            header("Location: " . URL . "administration/gestionBenevoles");
                        }
                        break;


                        //afficher admins
                    case "gestionAdministrateurs":
                        $administrateurGestionAdministrateursController->gestionAdministrateurs();
                        break;
                        //ajouter admins
                    case "ajout_administrateur":
                        $administrateurGestionAdministrateursController->ajout_administrateur();
                        break;
                    case "validation_creationAdministrateur":
                        if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['mail'] && preg_match('#^[a-zA-Z0-9]*$#', $_POST['login']))) {
                            $login = Securite::secureHTML($_POST['login']);
                            $password = Securite::secureHTML($_POST['password']);
                            $mail = Securite::secureHTML($_POST['mail']);
                            $est_valide = Securite::secureHTML($_POST['est_valide']);
                            $role = Securite::secureHTML($_POST['role']);
                            $administrateurGestionAdministrateursController->validation_creationAdministrateur($login, $password, $mail, $est_valide, $role);
                        } else {
                            Toolbox::ajouterMessageAlerte("Il manque une information ou un caractère interdit a été saisi", Toolbox::COULEUR_ROUGE);
                            header("Location: " . URL . "administration/gestionAdministrateurs");
                        }
                        break;
                        //supprimer admin
                    case "suppression_administrateur":
                        $administrateurGestionAdministrateursController->suppression_administrateur($_POST['login']);
                        break;
                        //modifier admin
                    case "validation_modificationRoleAdministrateur":
                        $administrateurGestionAdministrateursController->validation_modificationRoleAdministrateur($_POST['login'], $_POST['role']);
                        break;
                    case "validation_modificationValidationCompteAdministrateur":
                        $administrateurGestionAdministrateursController->validation_modificationValidationCompteAdministrateur($_POST['login'], $_POST['est_valide']);
                        break;

                        //afficher missions
                    case "gestionMissions":
                        $administrateurGestionMissionsController->gestionMissions();
                        break;
                        //ajouter mission
                    case "ajout_mission":
                        $administrateurGestionMissionsController->ajout_mission();
                        break;
                    case "validation_creationMission":
                        if (!empty($_POST['nom_mission']) && !empty($_POST['description_mission'])) {
                            $nom_mission = Securite::secureHTML($_POST['nom_mission']);
                            $description_mission = Securite::secureHTML($_POST['description_mission']);
                            $id_mission = $administrateurGestionMissionsController->validation_creationMission($nom_mission, $description_mission);
                        } else {
                            Toolbox::ajouterMessageAlerte("Il manque une information ou un caractère interdit a été saisi", Toolbox::COULEUR_ROUGE);
                            header("Location: " . URL . "administration/gestionMissions");
                        }
                        break;
                    case "modification_mission":
                        // var_dump(explode("/", $_SERVER['REQUEST_URI']));
                        // die;
                        $administrateurGestionMissionsController->modification_mission();
                        break;

                    case "validation_modificationMission":
                        if (!empty($_POST['id_mission']) && (!empty($_POST['nom_mission']) || !empty($_POST['description_mission']))) {
                            // var_dump($_POST);
                            // die;
                            $id_mission = Securite::secureHTML($_POST['id_mission']);
                            $nom_mission = Securite::secureHTML($_POST['nom_mission']);
                            $description_mission = Securite::secureHTML($_POST['description_mission']);
                            $administrateurGestionMissionsController->validation_modificationMission($id_mission,$nom_mission, $description_mission);
                        } else {
                            Toolbox::ajouterMessageAlerte("Il manque une information ou un caractère interdit a été saisi", Toolbox::COULEUR_ROUGE);
                            header("Location: " . URL . "administration/gestionMissions");
                        }
                        break;

                    case "suppression_mission":
                        $administrateurGestionMissionsController->suppression_mission((int)Securite::secureHTML($_POST['id_mission']));
                        break;

                        case "gestionCandidatures":
                            $administrateurGestionCandidaturesController->gestionCandidatures();
                            break;

                    default:
                        throw new Exception("La page n'existe pas");
                }
            }
            break;
        default:
            throw new Exception("La page n'existe pas");
    }
} catch (Exception $e) {
    $visiteurController->pageErreur($e->getMessage());
}
