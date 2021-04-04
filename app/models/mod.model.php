<?php

class ModModel extends Mvc\Model {
    
    /**
     * gets mod details
     * 
     * @param int $id
     * 
     * @return array|false first contains mod data, false in case of error
     */
    public function getDetails($id) {
        $sql = "SELECT * FROM mods WHERE id = ?";
        $query = $this->executeStmt($sql, [$id]);

        // tries to run the query
        if ($query) {
            // returns an associative array with the mod data
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function doesNameExists($name) {
        $sql = "SELECT COUNT(*) FROM mods WHERE name = ?";
        $query = $this->executeStmt($sql, [$name]);

        // tries to run the query
        if ($query) {
            // checks if the email is already registered
            if ($query->fetch(PDO::FETCH_COLUMN) == 1) {
                return true;
            }
            return false;
        }
        $this->PDOError = true;
        return false;
    }
}