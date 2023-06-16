<?php

    require_once("console.php");
    require_once("database.php");
    require_once("vendor/autoload.php");

    // check PHP version
    if (defined('PHP_MAJOR_VERSION') &&  PHP_MAJOR_VERSION < 8) 
    {
        Console::output("This script requires PHP Version > 8 to run.");
        die();
    } 

    // overridden directive values
    $file_name = null;
    $dry_run = false;
    $create_users_table = false;
    $database_host = null;
    $database_username = null;
    $database_password = null;

    // handle command line directives
    $directives = Console::get_options();
    foreach ($directives as $directive => $value) {

        switch ($directive) {
            case Console::$DIRECTIVE_HELP:
                Console::display_directives();
                die();
            case Console::$DIRECTIVE_FILE:
                $file_name = $value;
                break;
            case Console::$DIRECTIVE_DRY_RUN:
                $dry_run = true;
                break;
            case Console::$DIRECTIVE_CREATE_TABLE:
                $create_users_table = true;
                break;
            case Console::$DIRECTIVE_DB_HOST:
                $database_host = $value;
                break;
            case Console::$DIRECTIVE_DB_USERNAME:
                $database_username = $value;
                break;
            case Console::$DIRECTIVE_DB_PASSWORD:
                $database_password = $value;
                break;
        }
    }

    // create instance of Database class
    $database = new Database($database_host, $database_username, $database_password);

    // create the users table if requested by directive
    if ($create_users_table) {
        $database->create_users_table();

        // do not complete further actions
        die();
    }

    // load file into table if requested by directive
    if ($file_name) {
        $database->import_csv($file_name, $dry_run);
    }

    