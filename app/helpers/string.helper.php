<?php

class StringHelper {

    /**
     * replaces dashes with spaces and uppercase the first character of an error
     * 
     * @param string $error the error to be formatted
     * 
     * @return string the formatted error
     */
    public static function formatError(string $error): string {
        return ucfirst(str_replace("-", " ", $error));
    }
}