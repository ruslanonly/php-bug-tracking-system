<?php 
    $hostname = 'db';
    $username = 'bts_user';
    $password = 'bts_password';
    $databaseName = 'bts_database';

    class DatabaseManager {
        private $MySQLConnection;

        function __construct($hostname, $username, $password, $databaseName) {
            $this->MySQLConnection = new mysqli($hostname, $username, $password, $databaseName);
            if ($this->MySQLConnection->connect_error) {
                die("Connection failed: " . $this->MySQLConnection->connect_error);
            }
        }
        
        function getMySQLConnection() {
            return $this->MySQLConnection;
        }
    }
?>