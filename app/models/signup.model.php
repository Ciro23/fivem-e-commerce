<?php

class SignupModel extends Mvc\Model {

    /**
     * @var string|false $signupError
     */
    public $signupError = false;

    /**
     * @var string $email
     */
    public $email;

    /**
     * @var string $username
     */
    public $username;

    /**
     * @var string $password
     */
    private $password;

    /**
     * @var string $rePassword
     */
    private $rePassword;

    /**
     * replaces dashes with spaces and uppercase the first character of an error
     * 
     * @param string $error the error to be formatted
     * 
     * @return string the formatted error
     */
    public static function formatError($error) {
        return ucfirst(str_replace("-", " ", $error));
    }

    /**
     * performs the signup action
     * 
     * @param object $userModel
     * 
     * @return bool success status
     */
    public function signup($userModel) {
        // gets user input from the html form
        extract($_POST);

        // sanitizes the input
        $this->email = htmlspecialchars($email);
        $this->username = htmlspecialchars($username);
        $this->password = htmlspecialchars($password);
        $this->rePassword = htmlspecialchars($rePassword);

        // checks for errors
        if (
            $this->validateEmail($userModel)
            || $this->validateUsername()
            || $this->validatePassword()
        ) {
            return false;
        }

        // hashes the password
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

        // insert the data into the db and creates the session
        if ($this->insertIntoDb()) {
            $_SESSION['uid'] = $this->lastInsertId();
            return true;
        }
        // in case of query failure
        $this->signupError = "something-went-wrong";
        return false;
    }

    /**
     * validates the email
     * 
     * @param object $userModel
     * 
     * @return bool true on error, false otherwise
     */
    private function validateEmail($userModel) {
        if (empty($this->email)) {
            $this->signupError = "email-cant-be-empty";
            return true;
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->signupError = "invalid-email-format";
            return true;
        }

        if ($userModel->doesEmailExists($this->email)) {
            // checks if the error is db related
            if ($userModel->error) {
                $this->signupError = "something-went-wrong";
            } else {
                $this->signupError = "email-is-already-registered";
            }
            return true;
        }

        return false;
    }

    /**
     * validate the username
     * 
     * @return bool true on error, false otherwise
     */
    private function validateUsername() {
        if (empty($this->username)) {
            $this->signupError = "username-cant-be-empty";
            return true;
        }

        if (!preg_match("/^[A-Za-z0-9]+$/", $this->username)) {
            $this->signupError = "username-can-only-contains-alphanumeric-characters";
            return true;
        }

        if (strlen($this->username) < 4 || strlen($this->username) > 20) {
            $this->signupError = "username-length-must-be-between-4-and-20";
            return true;
        }

        return false;
    }

    /**
     * validate the password
     * 
     * @return bool true on error, false otherwise
     */
    private function validatePassword() {
        if (empty($this->password)) {
            $this->signupError = "password-cant-be-empty";
            return true;
        }

        if (strlen($this->password) < 6 || strlen($this->password) > 72) {
            $this->signupError = "password-length-must-be-between-6-and-72";
            return true;
        }

        if ($this->password != $this->rePassword) {
            $this->signupError = "passwords-do-not-match";
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
        $sql = "INSERT INTO user (email, username, password) VALUES (?, ?, ?)";
        $inParameters = [$this->email, $this->username, $this->password];

        // tries to run the query
        if ($this->executeStmt($sql, $inParameters)) {
            return true;
        }
        $this->error = true;
        return false;
    }
}
