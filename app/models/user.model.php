<?php

class UserModel extends Mvc\Model {

    /**
     * gets the user password given the email
     * 
     * @param string $email
     * 
     * @return string|false the email or false on failure
     */
    public function getUserPasswordByEmail($email) {
        $sql = "SELECT password FROM users WHERE email = ?";
        $params = [$email];
        $query = $this->executeStmt($sql, $params);

        // tries to run the query
        if ($query) {
            return $query->fetch(PDO::FETCH_COLUMN);
        }
        
        return false;
    }

    /**
     * checks if the email already exists in the db
     * 
     * @param string $email
     * 
     * @return bool success status
     */
    public function doesUserEmailExists($email) {
        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
        $params = [$email];
        $query = $this->executeStmt($sql, $params);

        // tries to run the query
        if ($query) {
            // checks if the email is already registered
            if ($query->fetch(PDO::FETCH_COLUMN) == 1) {
                return true;
            }
            return false;
        }
        
        return false;
    }

    /**
     * gets the user id by his email
     * 
     * @param string $email
     * 
     * @return int|false id in case of success, false otherwise
     */
    public function getUserIdByEmail($email) {
        $sql = "SELECT id FROM users WHERE email = ?";
        $params = [$email];
        $query = $this->executeStmt($sql, $params);

        // tries to run the query
        if ($query) {
            return $query->fetch(PDO::FETCH_COLUMN);
        }
        
        return false;
    }

    /**
     * checks if the user is admin
     * 
     * @param int $id
     * 
     * @return bool success status
     */
    public function isUserAdmin($id) {
        if ($this->getUserRole($id) == 1) {
            return true;
        }
        return false;
    }

    /**
     * gets the user role
     * 
     * @param int $id
     * 
     * @return int|false role in case of success, false otherwise
     */
    public function getUserRole($id) {
        $sql = "SELECT role FROM users WHERE id = ?";
        $params = [$id];
        $query = $this->executeStmt($sql, $params);

        // tries to run the query
        if ($query) {
            return $query->fetch(PDO::FETCH_COLUMN);
        }
        
        return false;
    }
}
