<?php
require_once("./controllers/MainController.controller.php");
require_once("./models/Utilisateur/Utilisateur.model.php");

class UtilisateurController extends MainController{
    private $utilisateurManager;

    public function __construct(){
        $this->utilisateurManager = new UtilisateurManager();
    }

    //*** CONNEXION DE L'UTILISATEUR ***//
    public function validation_login($login,$password){
        if($this->utilisateurManager->isCombinaisonValide($login,$password)){
            if($this->utilisateurManager->estCompteActive($login)){
                Toolbox::ajouterMessageAlerte("Bienvenue sur le site ".$login." !", Toolbox::COULEUR_VERTE);
                $_SESSION['profil'] = [
                    "login" => $login,
                ];
                //génération de cookie
                Securite::genererCookieConnexion();
                header("location: ".URL."compte/profil");
            } else {
                $msg = "Le compte ".$login. " n'a pas été activé par mail. ";
                $msg .= "<a href='renvoyerMailValidation/".$login."'>Renvoyez le mail de validation</a>";
                Toolbox::ajouterMessageAlerte($msg, Toolbox::COULEUR_ROUGE);
                header("Location: ".URL."login");
            }
        } else {
            Toolbox::ajouterMessageAlerte("Combinaison Login / Mot de passe non valide", Toolbox::COULEUR_ROUGE);
            header("Location: ".URL."login");
        }
    }
    //*** AFFICHAGE DU PROFIL ***//
    public function profil(){
        $datas = $this->utilisateurManager->getUserInformation($_SESSION['profil']['login']);
        $_SESSION['profil']["role"] = $datas['role'];
        
        $data_page = [
            "page_description" => "Page de profil",
            "page_title" => "Page de profil",
            "utilisateur" => $datas,
            "page_javascript" => ['profil.js'],
            "view" => "views/Utilisateur/profil.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }
    //*** DECONNEXION DE L'UTILISATEUR ***//
    public function deconnexion(){
        Toolbox::ajouterMessageAlerte("La deconnexion est effectuée",Toolbox::COULEUR_VERTE);
        unset($_SESSION['profil']);
        //cookie expire
        setCookie(Securite::COOKIE_NAME,"",time()-3600);
        header("Location: ".URL."accueil");
    }

    //*** CREATION DE COMPTE UTILISATEUR ***//
    public function validation_creerCompte($login,$password,$mail,$prenom,$nom,$telephone){
        if($this->utilisateurManager->verifLoginDisponible($login)){
            $passwordCrypte = password_hash($password,PASSWORD_DEFAULT);
            $clef = rand(0,9999);
            if($this->utilisateurManager->bdCreerCompte($login,$passwordCrypte,$mail,$clef,"profils/profil.png","utilisateur",$prenom,$nom,$telephone)){
                $this->sendMailValidation($login,$mail,$clef);
                Toolbox::ajouterMessageAlerte("La compte a été créé, Un mail de validation vous a été envoyé !", Toolbox::COULEUR_VERTE);
                header("Location: ".URL."login");
            } else {
                Toolbox::ajouterMessageAlerte("Erreur lors de la création du compte, recommencez !", Toolbox::COULEUR_ROUGE);
                header("Location: ".URL."creerCompte");
            }
        } else {
            Toolbox::ajouterMessageAlerte("Le login est déjà utilisé !", Toolbox::COULEUR_ROUGE);
            header("Location: ".URL."creerCompte");
        }
    }

    /**
     * ENVOI OU RENVOI DE L'EMAIL DE VALIDATION
     * VERIFICATION DU BON EMAIL
     * VALIDATION EMAIL/COMPTE
     * ET VALIDATION DE LA MODIF EMAIL A LA DEMANDE DE L'USER
     *  
    */
    private function sendMailValidation($login,$mail,$clef){
        $urlVerification = URL."validationMail/".$login."/".$clef;
        $sujet = "Creation du compte sur le site AsmadaBenevolat";
        $message = "Pour valider votre compte veuillez cliquer sur le lien suivant ".$urlVerification;
        Toolbox::sendMail($mail,$sujet,$message);
    }
    public function renvoyerMailValidation($login){
        $utilisateur = $this->utilisateurManager->getUserInformation($login);
        $this->sendMailValidation($login,$utilisateur['mail'],$utilisateur['clef']);
        header("Location: ".URL."login");
    }
    public function validation_mailCompte($login,$clef){
        if($this->utilisateurManager->bdValidationMailCompte($login,$clef)){
            Toolbox::ajouterMessageAlerte("Le compte a été activé !", Toolbox::COULEUR_VERTE);
            $_SESSION['profil'] = [
                "login" => $login,
            ];
            header('Location: '.URL.'compte/profil');
        } else {
            Toolbox::ajouterMessageAlerte("Le compte n'a pas été activé !", Toolbox::COULEUR_ROUGE);
            header('Location: '.URL.'creerCompte');
        }
    }
    public function validation_modificationMail($mail){
        if($this->utilisateurManager->bdModificationMailUser($_SESSION['profil']['login'],$mail)){
            Toolbox::ajouterMessageAlerte("La modification est effectuée", Toolbox::COULEUR_VERTE);
        } else {
            Toolbox::ajouterMessageAlerte("Aucune modification effectuée", Toolbox::COULEUR_ROUGE);
        }
        header("Location: ".URL."compte/profil");
    }

    //*** DEMANDE ET VALIDATION DE CHANGEMENT MOT DE PASSE PAR L'USER ***//
    public function modificationPassword(){
        $data_page = [
            "page_description" => "Page de modification du password",
            "page_title" => "Page de modification du password",
            "page_javascript" => ["modificationPassword.js"],
            "view" => "views/Utilisateur/modificationPassword.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }
    public function validation_modificationPassword($ancienPassword,$nouveauPassword,$confirmationNouveauPassword){
        if($nouveauPassword === $confirmationNouveauPassword){
            if($this->utilisateurManager->isCombinaisonValide($_SESSION['profil']['login'],$ancienPassword)){
                $passwordCrypte = password_hash($nouveauPassword,PASSWORD_DEFAULT);
                if($this->utilisateurManager->bdModificationPassword($_SESSION['profil']['login'],$passwordCrypte)){
                    Toolbox::ajouterMessageAlerte("La modification du password a été effectuée", Toolbox::COULEUR_VERTE);
                    header("Location: ".URL."compte/profil");
                } else {
                    Toolbox::ajouterMessageAlerte("La modification a échouée", Toolbox::COULEUR_ROUGE);
                    header("Location: ".URL."compte/modificationPassword");
                }
            } else {
                Toolbox::ajouterMessageAlerte("La combinaison login / ancien password ne correspond pas", Toolbox::COULEUR_ROUGE);
                header("Location: ".URL."compte/modificationPassword");
            }            
        } else {
            Toolbox::ajouterMessageAlerte("Les passwords ne correspondent pas", Toolbox::COULEUR_ROUGE);
            header("Location: ".URL."compte/modificationPassword");
        }
    }

    //*** DEMANDE ET VALIDATION DE SUPPRESSION DE COMPTE PAR L'USER ***//
    public function suppressionCompte(){
        $this->dossierSuppressionImageUtilisateur($_SESSION['profil']['login']);
        rmdir("public/Assets/images/profils/".$_SESSION['profil']['login']);

        if($this->utilisateurManager->bdSuppressionCompte($_SESSION['profil']['login'])) {
            Toolbox::ajouterMessageAlerte("La suppression du compte est effectuée", Toolbox::COULEUR_VERTE);
            $this->deconnexion();
        } else {
            Toolbox::ajouterMessageAlerte("La suppression n'a pas été effectuée. Contactez l'administrateur",Toolbox::COULEUR_ROUGE);
            header("Location: ".URL."compte/profil");
        }
    }

    //*** ACTION ET VALIDATION DE CHANGEMENT PHOTO PAR L'USER ***//
    public function validation_modificationImage($file){
        try{
            $repertoire = "public/Assets/images/profils/".$_SESSION['profil']['login']."/";
            $nomImage = Toolbox::ajoutImage($file,$repertoire);//ajout image dans le répertoire
            //Supression de l'ancienne image
            $this->dossierSuppressionImageUtilisateur($_SESSION['profil']['login']);
            //Ajout de la nouvelle image dans la BD
            $nomImageBD = "profils/".$_SESSION['profil']['login']."/".$nomImage;
            if($this->utilisateurManager->bdAjoutImage($_SESSION['profil']['login'],$nomImageBD)){
                Toolbox::ajouterMessageAlerte("La modification de l'image est effectuée", Toolbox::COULEUR_VERTE);
            } else {
                Toolbox::ajouterMessageAlerte("La modification de l'image n'a pas été effectuée", Toolbox::COULEUR_ROUGE);
            }
        } catch(Exception $e){
            Toolbox::ajouterMessageAlerte($e->getMessage(), Toolbox::COULEUR_ROUGE);
        }
      
        header("Location: ".URL."compte/profil");
    }

    //*** SUPPRESSION IMAGE PAR L'USER ***//
    private function dossierSuppressionImageUtilisateur($login){
        $ancienneImage = $this->utilisateurManager->getImageUtilisateur($_SESSION['profil']['login']);
        if($ancienneImage !== "profils/profil.png"){
            unlink("public/Assets/images/".$ancienneImage);
        }
    }

    //*** CONSULTATION DES MISSIONS PAR L'UTILISATEUR ***//
    public function missions(){
        $missions = $this->utilisateurManager->getMissions();
        $data_page = [
            "page_description" => "Page des missions",
            "page_title" => "Page des missions",
            "missions" => $missions,
            "view" => "views/Utilisateur/missionsUtilisateur.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

    //CANDIDATER
    public function candidater()
    {
        $data_page = [
            "page_description" => "Page de candidature",
            "page_title" => "Page de candidature",
            "view" => "views/Utilisateur/formulaireCandidature.view.php",
            "template" => "views/common/template.php"
        ];
        $this->genererPage($data_page);
    }

    //CONSULTER LES REPONSES DES ADMINS SUR LES CANDIDATURES DE L'UTILISATEUR
    public function historiqueCandidatures(){
        
    }

    public function pageErreur($msg){
        parent::pageErreur($msg);
    }
}