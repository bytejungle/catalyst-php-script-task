<?php

    class StringHelper {

        // formats a name
        public static function format_name($string) {

            // remove white space
            $string = trim($string);

            // make lowercase
            $string = strtolower($string);

            // make first letter uppercase
            $string = ucfirst($string);

            // return value
            return $string;
        }

        // formats an email address
        public static function format_email_address($string) {

            // remove white space
            $string = trim($string);

            // make lowercase and return value
            return strtolower($string);
        }
        
        // checks if a name is valid
        public static function is_name_valid($string) {
            return ctype_alpha($string);
        }

        // checks if an email address is valid
        public static function is_email_address_valid($string) {
            return filter_var($string, FILTER_VALIDATE_EMAIL);
        }
    }