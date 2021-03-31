<?php

class UserModel extends Mvc\Model {

    /**
     * gets the user password given the email
     * 
     * @param string $email
     * 
     * @return string|bool the email or false on failure
     */
    public function getUserPassword($email) {
        $sql = "SELECT password FROM user WHERE email = ?";
        $inParameters = [$email];

        // tries to run the query
        if ($query = $this->executeStmt($sql, $inParameters)) {
            return $query->fetch(PDO::FETCH_COLUMN);
        }
        $this->error = true;
        return false;
    }

    /**
     * checks if the email already exists in the db
     * 
     * @param string $email
     * 
     * @return bool success status
     */
    public function doesEmailExists($email) {
        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
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
        return false;
    }

    /**
     * gets the user id by his email
     * 
     * @param string $email
     * 
     * @return int|bool id in case of success, false otherwise
     */
    public function getIdByEmail($email) {
        $sql = "SELECT id FROM user WHERE email = ?";
        $query = $this->executeStmt($sql, [$email]);

        // tries to run the query
        if ($query) {
            return $query->fetch(PDO::FETCH_COLUMN);
        }
        $this->error = true;
        return false;
    }
}
