<?php

class ModModel extends Mvc\Model {
    
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