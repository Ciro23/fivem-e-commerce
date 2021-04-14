<?php

class SignupModel extends Mvc\Model {

    /**
     * @var string $signupError
     */
    private string $signupError = "";

    /**
     * @var array $userData contains all form userData
     */
    private array $userData = [
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
    public function getSignupError(): string {
        return $this->signupError;
    }

    /**
     * returns the email
     * 
     * @return string
     */
    public function getUserEmail(): string {
        return $this->userData['email'];
    }

    /**
     * returns the username
     * 
     * @return string
     */
    public function getUsername(): string {
        return $this->userData['username'];
    }

    /**
     * performs the signup action
     * 
     * @param array $inputData
     * @param object $userModel
     * 
     * @return bool success status
     */
    public function signup(array $inputData, UserModel $userModel): bool {
        // gets the form input
        $this->userData = InputHelper::getFormInput($this->userData, $inputData);

        // checks for errors
        if (
            $this->validateUserEmail($userModel)
            || $this->validateUsername()
            || $this->validateUserPassword()
        ) {
            return false;
        }

        // hashes the password
        $this->userData['password'] = password_hash($this->userData['password'], PASSWORD_BCRYPT);

        // insert the user userData into the db and creates the session
        if ($this->insertIntoDb()) {
            $_SESSION['uid'] = $this->lastInsertId("users");
            return true;
        }
        // in case of query failure
        $this->signupError = "something-went-wrong";
        return false;
    }

    /**
     * checks if the email is valid
     * 
     * @param object $userModel
     * 
     * @return bool true on error, false otherwise
     */
    private function validateUserEmail(UserModel $userModel): bool {
        if (empty($this->userData['email'])) {
            $this->signupError = "email-cant-be-empty";
            return true;
        }

        if (!filter_var($this->userData['email'], FILTER_VALIDATE_EMAIL)) {
            $this->signupError = "invalid-email-format";
            return true;
        }

        if ($userModel->doesUserEmailExists($this->userData['email'])) {
            // checks if the error is db related
            if ($userModel->PDOError) {
                $this->signupError = "something-went-wrong";
            } else {
                $this->signupError = "email-is-already-registered";
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
    private function validateUsername(): bool {
        if (empty($this->userData['username'])) {
            $this->signupError = "username-cant-be-empty";
            return true;
        }

        if (!preg_match("/^[A-Za-z0-9]+$/", $this->userData['username'])) {
            $this->signupError = "username-can-only-contains-alphanumeric-characters";
            return true;
        }

        if (strlen($this->userData['username']) < 4 || strlen($this->userData['username']) > 20) {
            $this->signupError = "username-length-must-be-between-4-and-20";
            return true;
        }

        return false;
    }

    /**
     * che if the password is valid
     * 
     * @return bool true on error, false otherwise
     */
    private function validateUserPassword(): bool {
        if (empty($this->userData['password'])) {
            $this->signupError = "password-cant-be-empty";
            return true;
        }

        if (strlen($this->userData['password']) < 6 || strlen($this->userData['password']) > 72) {
            $this->signupError = "password-length-must-be-between-6-and-72";
            return true;
        }

        if ($this->userData['password'] != $this->userData['rePassword']) {
            $this->signupError = "passwords-do-not-match";
            return true;
        }

        return false;
    }

    /**
     * insert the userData into the db
     * 
     * @return bool success status
     */
    private function insertIntoDb(): bool {
        $sql = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
        $params = [$this->userData['email'], $this->userData['username'], $this->userData['password']];

        // tries to run the query
        if ($this->executeStmt($sql, $params)) {
            return true;
        }
        
        return false;
    }
}
