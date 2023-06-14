<?php

    require_once("console.php");
    require_once("database.php");

    // overridden directive values
    $create_users_table = false;
    $database_host = null;
    $database_username = null;
    $database_password = null;

    // handle command line directives
    foreach ($argv as $index => $argument) {

        // skip file name arg
        if (str_contains($argument, "user_upload.php")) continue;

        // explode argument into key pair values
        $directive_and_value = explode("=", $argument);

        $directive = $directive_and_value[0];
        $directive_value = $directive_and_value[1] ?? null;

        // check if directive is valid
        if (!in_array($directive, Console::getAvailableDirectives())) {
            Console::output("The directive $directive is not valid!");
            die();
        }

        // handle directives

        switch ($directive) {
            case Console::$DIRECTIVE_CREATE_TABLE:
                $create_users_table = true;
                break;
            case Console::$DIRECTIVE_DB_HOST:
                $database_host = $directive_value;
                break;
            case Console::$DIRECTIVE_DB_USERNAME:
                $database_username = $directive_value;
                break;
            case Console::$DIRECTIVE_DB_PASSWORD:
                $database_password = $directive_value;
                break;
            case Console::$DIRECTIVE_HELP:
                Console::displayDirectives();
                break;
        }
    }

    // create instance of Database class
    $database = new Database($database_host, $database_username, $database_password);

    // create the users table if requested by directive
    if ($create_users_table) {
        $database->createUsersTable();
    }

    