<?php

    require_once("console.php");

    class Database {

        // the PDO database connection
        private $connection;

        // the database details
        private $database_host;
        private $database_name;
        private $database_username;
        private $database_password;

        // class constructor
        function __construct() {

            // load the environment variables file
            $env = parse_ini_file('.env');

            // extract database information from environment
            $this->database_host = $env['DATABASE_HOST'];
            $this->database_name = $env['DATABASE_NAME'];
            $this->database_username = $env['DATABASE_USERNAME'];
            $this->database_password = $env['DATABASE_PASSWORD'];

            try {
                
                // create new PDO connection
                $this->connection = new PDO("mysql:host=$this->database_host;dbname=$this->database_name", $this->database_username, $this->database_password);

                // set the PDO error mode to exception
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                Console::output("Database connection successful!");

            } catch (PDOException $e) {
                // exit script on connection failure
                Console::output("Database connection failed! Error: " . $e->getMessage());
                die();
            }
        }

        // creates the users table in the database
        function createUsersTable() {

            try {
                $sql = "CREATE TABLE IF NOT EXISTS users (name varchar(255) NOT NULL, surname varchar(255) NOT NULL, email VARCHAR(255) NOT NULL UNIQUE)";
                $this->connection->query($sql);
    
                Console::output("User table creation successful!");
            } catch (PDOException $e) {
                Console::output("User table creation failed! Error: " . $e->getMessage());
            }
        }

        public function getConnection() {
            return $this->connection;
        }
    }