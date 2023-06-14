<?php

    require_once("console.php");

    class Console {

        // the available directives
        public static $DIRECTIVE_FILE = "--file";
        public static $DIRECTIVE_CREATE_TABLE = "--create_table";
        public static $DIRECTIVE_DRY_RUN = "--dry_run";
        public static $DIRECTIVE_DB_USERNAME = "-u";
        public static $DIRECTIVE_DB_PASSWORD = "-p";
        public static $DIRECTIVE_DB_HOST = "-h";
        public static $DIRECTIVE_HELP = "--help";
        
        private static $directives = [
            "--file" => "The name of the CSV to be parsed.",
            "--create_table" => "Cause the MySQL users table to be built (and no further action will be taken).",
            "--dry_run" => "Used with --file directive in case we want to run the script but not insert into the DB. All other functions will be executed, but the database won't be altered.",
            "-u" => "Provide MySQL username.",
            "-p" => "Provide MySQL password.",
            "-h" => "Provide MySQL host.",
            "--help" => "Output the above list of directives."
        ];
        
        // standard output the message with a new line character for readability
        public static function output($message) {
            fwrite(STDOUT, $message . PHP_EOL);
        }

        // displays available directives with details
        public static function displayDirectives() {
            self::output("DISPLAYING HELP:");
            foreach (self::$directives as $directive => $description) {
                self::output("$directive: $description");
            }
        }

        // returns an array of available directives
        public static function getAvailableDirectives() {
            return array_keys(self::$directives);
        }
    }