<?php
/* 
La connexion à la bdd c'est ici ^^
*/

abstract class Model{//abstract car jamais instanciable
    private static $pdo;

    private static function setBdd(){
        self::$pdo = new PDO("mysql:host=localhost;dbname=asmada;charset=utf8","root","");
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
    }

    //vérification de la connexion
    protected function getBdd(){
        if(self::$pdo === null){
            self::setBdd();
        }
        return self::$pdo;
    }

    //conversion des données au format json
    //static car appelable de n'importe ou depuis Model
    public static function sendJson($info){
        header("Access-Control-Allow-Origin: *");//demande faites peuvent venir de n'importe ou, n'importe qui peut interroger l'api rest
        //header("Access-Control-Allow-Origin: nom du site")
        header("Content-Type: application/json");//si app externe fait une req de récup de data, plus d'erreur
        echo json_encode($info);
    }


}