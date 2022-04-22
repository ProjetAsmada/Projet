<?php

/*
ici on gère les infos pour vérifier les 
formulaires et si l'user dispose des accès
*/
    class Securite{
        public static function secureHTML($string){
            return htmlentities($string);
        }
    }
?>