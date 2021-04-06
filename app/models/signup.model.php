<?php

class SignupModel extends Mvc\Model {

    /**
     * @var string $error
     */
    private $error = "";

    /**
     * @var array $data contains all form data
     */
    private $data = [
        "email" => "",
        "username" => "",
        "password" => "",
        "rePassword" => ""
    ];

    /**
     * returns the error
     * 
     * @return string
     */
    public function getError() {
        return $this->error;
    }

    /**
     * returns the email
     * 
     * @return string
     */
    public function getEmail() {
        return $this->data['email'];
    }

    /**
     * returns the username
     * 
     * @return string
     */
    public function getUsername() {
        return $this->data['username'];
    }

    /**
     * performs the signup action
     * 
     * @param object $userModel
     * 
     * @return bool success status
     */
    public function signup($userModel) {
        // gets the form input
        $this->data = InputHelper::getFormInput($this->data, $_POST);

        // checks for errors
        if (
            $this->validateEmail($userModel)
            || $this->validateUsername()
            || $this->validatePassword()
        ) {
            return false;
        }

        // hashes the password
        $this->data['password'] = password_hash($this->data['password'], PASSWORD_BCRYPT);

        // insert the data into the db and creates the session
        if (
            $this->insertIntoDb()
            && $_SESSION['uid'] = $userModel->getId($this->data['email'])
        ) {
            return true;
        }
        // in case of query failure
        $this->error = "something-went-wrong";
        return false;
    }

    /**
     * checks if the email is valid
     * 
     * @param object $userModel
     * 
     * @return bool true on error, false otherwise
     */
    private function validateEmail($userModel) {
        if (empty($this->data['email'])) {
            $this->error = "email-cant-be-empty";
            return true;
        }

        if (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->error = "invalid-email-format";
            return true;
        }

        if ($userModel->doesEmailExists($this->data['email'])) {
            // checks if the error is db related
            if ($userModel->PDOError) {
                $this->error = "something-went-wrong";
            } else {
                $this->error = "email-is-already-registered";
            }
            return true;
        }

        return false;
    }

    /**
     * checks if the username is valid
     * 
     * @return bool true on error, false otherwise
     */
    private function validateUsername() {
        if (empty($this->data['username'])) {
            $this->error = "username-cant-be-empty";
            return true;
        }

        if (!preg_match("/^[A-Za-z0-9]+$/", $this->data['username'])) {
            $this->error = "username-can-only-contains-alphanumeric-characters";
            return true;
        }

        if (strlen($this->data['username']) < 4 || strlen($this->data['username']) > 20) {
            $this->error = "username-length-must-be-between-4-and-20";
            return true;
        }

        return false;
    }

    /**
     * che if the password is valid
     * 
     * @return bool true on error, false otherwise
     */
    private function validatePassword() {
        if (empty($this->data['password'])) {
            $this->error = "password-cant-be-empty";
            return true;
        }

        if (strlen($this->data['password']) < 6 || strlen($this->data['password']) > 72) {
            $this->error = "password-length-must-be-between-6-and-72";
            return true;
        }

        if ($this->data['password'] != $this->data['rePassword']) {
            $this->error = "passwords-do-not-match";
            return true;
        }

        return false;
    }

    /**
     * insert the data into the db
     * 
     * @return bool success status
     */
    private function insertIntoDb() {
        $sql = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
        $inParameters = [$this->data['email'], $this->data['username'], $this->data['password']];

        // tries to run the query
        if ($this->executeStmt($sql, $inParameters)) {
            return true;
        }
        $this->PDOError = true;
        return false;
    }
}
