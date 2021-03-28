<?php

class LoginModel extends Mvc\Model {

    /**
     * performs the login action
     * 
     * @return bool success status
     */
    public function login() {
        // gets user input from the html form
        extract($_POST);

        // sanitizes the input
        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);
    }
}