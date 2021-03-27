<?php

class SignupModel extends Mvc\Model {

    public function signup() {
        // gets user input from the html form
        extract($_POST);

        // sanitizes the input
        $email = htmlspecialchars($email);
        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);
        $rePassword = htmlspecialchars($rePassword);


    }

    /**
     * validate the username
     * 
     * @param string $username
     * 
     * @return string|false, first contains error on failure, false otherwise
     */
    private function validateUsername($username) {
        if (empty($username)) {
            return "username-cant-be-empty";
        }

        if (strlen($username) < 4 || strlen($username) > 20) {
            return "username-length-must-be-between-4-and-20";
        }

        return false;
    }
}