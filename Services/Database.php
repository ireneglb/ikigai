<?php

namespace Services;

use PDO;
use Exception;
/**
 * Classe de gestion de la connexion à la base de données.
 */
class Database {    
    private static $dbHost = 'localhost' ;              
    private static $dbName = 'ikigai' ;                 
    private static $dbUsername = 'root';                
    private static $dbUserPassword = '';                
    private static $db = null;

    public function __construct()
    {
        self::connect(); 
    }

    public static function connect(): void 
    {
        try {
            // self::$db = new \PDO("mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword)-> rajout de charset
            self::$db = new \PDO("mysql:host=".self::$dbHost.";"."dbname=".self::$dbName.";charset=utf8", self::$dbUsername, self::$dbUserPassword); 
            
            
        } catch (\PDOException $error) {
            echo 'échec de la connexion : ' . $error->getMessage();
        }
    }

    public static function getConnection(): PDO
    {
        
        if(!empty(self::$db)){          
            return self::$db;
        }
        throw new Exception('mauvaise connexion');
    }
    
    public static function disconnect()
    {
        self::$db = null;
    }
}
