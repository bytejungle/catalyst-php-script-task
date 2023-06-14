<?php
use League\Csv\Reader;

    require_once("console.php");
    require_once("string_helper.php");

    class Database {

        // the PDO database connection
        private $connection;

        // the database details
        private $database_host;
        private $database_name;
        private $database_username;
        private $database_password;

        // class constructor
        function __construct($database_host = null, $database_username = null, $database_password = null) {

            // load the environment variables file
            $env = parse_ini_file('.env');

            // extract database information from environment
            $this->database_host = $database_host ?? $env['DATABASE_HOST'];
            $this->database_name = $env['DATABASE_NAME'];
            $this->database_username = $database_username ?? $env['DATABASE_USERNAME'];
            $this->database_password = $database_password ?? $env['DATABASE_PASSWORD'];

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
        public function create_users_table() {

            try {

                // drop the table if it already exists
                $sql = "DROP TABLE IF EXISTS users";
                $this->connection->query($sql);

                // create table
                $sql = "CREATE TABLE IF NOT EXISTS users (name varchar(255) NOT NULL, surname varchar(255) NOT NULL, email VARCHAR(255) NOT NULL UNIQUE)";
                $this->connection->query($sql);
    
                Console::output("User table creation successful!");
            } catch (PDOException $e) {
                Console::output("User table creation failed! Error: " . $e->getMessage());
            }
        }

        // reads a csv file and inserts the contents into the database
        public function import_csv($file_name, $dry_run = false) {

            try {

                // begins transaction
                $this->connection->beginTransaction();

                // prepare insert statement
                $sql = $this->connection->prepare("INSERT INTO users (name, surname, email) VALUES (:1, :2, :3)");

                $csv = Reader::createFromPath($file_name)->setHeaderOffset(0);

                // remove white space from headers
                $headers = array_map('trim', $csv->getHeader());
                foreach ($csv->getRecords($headers) as $record) {

                    // check if data is valid
                    $name = $record['name'];
                    $surname = $record['surname'];
                    $email = $record['email'];

                    $is_valid = StringHelper::is_name_valid($name) && 
                        StringHelper::is_name_valid($surname) && 
                        StringHelper::is_email_address_valid($email);

                    // format and save data if valid
                    if ($is_valid) {

                        // format data
                        $name = StringHelper::format_name($record['name']);
                        $surname = StringHelper::format_name($record['surname']);
                        $email = StringHelper::format_email_address($record['email']);

                        // bind and save data to database
                        $sql->bindValue(":1", $name, PDO::PARAM_STR);
                        $sql->bindValue(":2", $surname, PDO::PARAM_STR);
                        $sql->bindValue(":3", $email, PDO::PARAM_STR);
                        $sql->execute();
                    }
                }

                // commit the changes if not on dry run
                if (!$dry_run) {
                    $this->connection->commit();
                    Console::output("Data insertion complete!");
                } else {
                    Console::output("Data parse complete!");
                }

                
            } catch (Exception $e) {
                // roll back changes
                $this->connection->rollBack();
                Console::output("Data insertion failed! Error: " . $e->getMessage());
            }
        }
    }