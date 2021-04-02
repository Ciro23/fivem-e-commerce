<?php

class InputHelper {

    /**
     * saves only the needed input specified by the $array structure
     * 
     * eg:
     * 
     * having the following $array structure $array = ["foo" => "", "bar" => ""]
     * 
     * and the form input made like this $_POST = ["foo" => "x", "bar" => 10, "baz" => "y"]
     * 
     * only "foo" and "bar" are saved
     * 
     * @param array $array where the input values are going to be stored
     * @param array $form the where input values are initally stored (eg $_POST / $_FILES)
     * 
     * @return array
     */
    public static function getFormInput($array, $form) {
        foreach ($form as $keyForm => $valueForm) {
            foreach ($array as $keyArray => $valueArray) {
                if ($keyForm == $keyArray) {
                    // sanitizes and store the input
                    $array[$keyArray] = htmlspecialchars($valueForm);
                }
            }
        }
        return $array;
    }
}