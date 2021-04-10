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

        // tries to run the query
        if ($query = $this->executeStmt($sql, [$id])) {
            // returns an associative array with the mod data
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    /**
     * gets mod list by their status
     * 
     * @param int $status (0 => rejected, 1 => pending, 2 => approved)
     * 
     * @return array|false first contains mod list, false in case of error
     */
    public function getList($status) {
        $sql = "SELECT * FROM mods WHERE status = ?";

        // tries to run the query
        if ($query = $this->executeStmt($sql, [$status])) {
            // returns an associative array with the mod data
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    /**
     * checks if the mod name already exists in the db
     * 
     * @param string $name
     * 
     * @return bool success status
     */
    public function doesNameExists($name) {
        $sql = "SELECT COUNT(*) FROM mods WHERE name = ?";

        // tries to run the query
        if ($query = $this->executeStmt($sql, [$name])) {
            // checks if the email is already registered
            if ($query->fetch(PDO::FETCH_COLUMN) == 1) {
                return true;
            }
            return false;
        }
        $this->PDOError = true;
        return false;
    }

    /**
     * deletes mod row from the db
     * 
     * @param int $id
     * 
     * @return bool success status
     */
    public function deleteModFromDb($id) {
        $sql = "DELETE FROM mods WHERE id = ?";
        $inParameters = [$id];

        if ($this->executeStmt($sql, $inParameters)) {
            return true;
        }
        return false;
    }

    /**
     * deletes mod files from the server
     * 
     * @param int $id
     * 
     * @return bool success status
     */
    private function deleteModFiles($id) {
        //* to do
    }
}