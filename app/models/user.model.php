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
}