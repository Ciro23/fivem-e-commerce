<?php

class SignupModel extends Mvc\Model {

    /**
     * @var string|bool $signupError
     */
    public $signupError = false;

    /**
     * performs the signup action
     * 
     * @return bool success status
     */
    public function signup() {
        // gets user input from the html form
        extract($_POST);

        // sanitizes the input
        $email = htmlspecialchars($email);
        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);
        $rePassword = htmlspecialchars($rePassword);

        // checks for errors
        if (
            $this->validateEmail($email)
            || $this->validateUsername($username)
            || $this->validatePassword($password, $rePassword)
        ) {
            return false;
        }

        // insert the data into the db and creates the session
        if ($this->insertIntoDb($email, $username, $password)) {
            $_SESSION['uid'] = $this->lastInsertId();
            return true;
        }
        return false;
    }

    /**
     * validates the email
     * 
     * @param string $email
     * 
     * @return bool true on error, false otherwise
     */
    private function validateEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->signupError = "invalid-email-format";
            return true;
        }
        
        if ($this->emailExists($email)) {
            // checks if the error is db related
            if ($this->error) {
                $this->signupError = "something-went-wrong";
            } else {
                $this->signupError = "email-is-alread-registered";
            }
            return true;
        }

        return false;
    }

    private function emailExists($email) {
        $sql = "SELECT email FROM users WHERE email = ?";
        $query = $this->executeStmt($sql, [$email]);

        // tries to run the query
        if ($query) {
            // checks if the email is already registered
            if ($query->fetch(PDO::FETCH_COLUMN) == 1) {
                return true;
            }
            return false;
        }
        $this->error = true;
        return true;
    }

    /**
     * validate the username
     * 
     * @param string $username
     * 
     * @return bool true on error, false otherwise
     */
    private function validateUsername($username) {
        if (empty($username)) {
            $this->signupError = "username-cant-be-empty";
            return true;
        }
        
        if (strlen($username) < 4 || strlen($username) > 20) {
            $this->signupError = "username-length-must-be-between-4-and-20";
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
        if (empty($password)) {
            $this->signupError = "password-cant-be-empty";
            return true;
        }
        
        if (strlen($password) < 6 || strlen($password) > 72) {
            $this->signupError = "password-length-must-be-between-6-and-72";
            return true;
        }
        
        if ($password != $rePassword) {
            $this->signupError = "passwords-do-not-match";
            return true;
        }

        return false;
    }
    
    private function insertIntoDb($email, $username, $password) {
        $sql = "INSERT INTO user (email, username, password) VALUES (?, ?, ?)";
        $inParameters = [$email, $username, $password];

        // tries to run the query
        if ($query = $this->executeStmt($sql, $inParameters)) {
            return true;
        }
        $this->error = true;
        $this->signupError = "something-went-wrong";
        return false;
    }
}