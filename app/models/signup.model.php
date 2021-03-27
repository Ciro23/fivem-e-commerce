<?php

class SignupModel extends Mvc\Model {

    /**
     * @var string error
     */
    public $error;

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
     * @return bool true on error, false otherwise
     */
    private function validateUsername($username) {
        $error = false;

        if (empty($username)) {
            $error = "username-cant-be-empty";
        }

        if (strlen($username) < 4 || strlen($username) > 20) {
            $error = "username-length-must-be-between-4-and-20";
        }

        if ($error) {
            return true;
        }
        return false;
    }

    /**
     * validate the password
     * 
     * @param string $password
     * @param string $rePassword
     * 
     * @return bool true on error, false otherwise
     */
    private function validatePassword($password, $rePassword) {
        $error = false;

        if (empty($password)) {
            $error = "password-cant-be-empty";
        }

        if (strlen($password) < 6 || strlen($password) > 64) {
            $error = "password-length-must-be-between-6-and-64";
        }

        if ($password != $rePassword) {
            $error = "passwords-do-not-match";
        }

        if ($error) {
            return true;
        }
        return false;
    }
}