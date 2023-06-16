<?php

    require_once("console.php");

    class Console {

        // the available directives
        public static $DIRECTIVE_FILE = "file";
        public static $DIRECTIVE_CREATE_TABLE = "create_table";
        public static $DIRECTIVE_DRY_RUN = "dry_run";
        public static $DIRECTIVE_DB_USERNAME = "u";
        public static $DIRECTIVE_DB_PASSWORD = "p";
        public static $DIRECTIVE_DB_HOST = "h";
        public static $DIRECTIVE_HELP = "help";
        
        // the short directives - single dash
        private static $SHORT_DIRECTIVES = [
            "u" => "Provide MySQL username.",
            "p" => "Provide MySQL password.",
            "h" => "Provide MySQL host."
        ];

        // the long directives - double dash
        private static $LONG_DIRECTIVES = [
            "file" => "The name of the CSV to be parsed.",
            "create_table" => "Cause the MySQL users table to be built (and no further action will be taken).",
            "dry_run" => "Used with --file directive in case we want to run the script but not insert into the DB. All other functions will be executed, but the database won't be altered.",
            "help" => "Output the above list of directives."
        ];
        
        // standard output the message with a new line character for readability
        public static function output($message) {
            fwrite(STDOUT, $message . PHP_EOL);
        }

        // displays available directives with details
        public static function display_directives() {

            $output = "";

            // format short directives
            foreach (self::$SHORT_DIRECTIVES as $directive => $description) {
                $output .= self::formatDirectiveHelp($directive, $description, false);
            }

            // format long directives
            foreach (self::$LONG_DIRECTIVES as $directive => $description) {
                $output .= self::formatDirectiveHelp($directive, $description, true);
            }

            self::output("DISPLAYING HELP:");
            self::output($output);
        }

        // formats a directive for output in command line
        private static function formatDirectiveHelp($directive, $description, $is_long_directive) {
            // long directives have a double dash
            $prefix = $is_long_directive ? "--" : "-";

            // return the formatted string
            return $prefix . $directive . ": " . $description . PHP_EOL;
        }

        // returns the short directives for use in php getopt function
        private static function get_short_directives() {
            return implode("::", array_keys(self::$SHORT_DIRECTIVES));
        }

        // returns the long directives for use in php getopt function
        private static function get_long_directives() {
            return array_map(function ($directive) {
                return $directive . "::";
            }, array_keys(self::$LONG_DIRECTIVES));
        }

        // php get options using available directives
        public static function get_options() {
            return getopt(self::get_short_directives(), self::get_long_directives());
        }
    }