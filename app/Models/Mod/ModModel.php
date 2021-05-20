<?php

namespace App\Models\Mod;

use Config\Database;
use CodeIgniter\Model;

class ModModel extends Model {
    
    private object $conn;

    public function __construct() {
        parent::__construct();
        $this->conn = Database::connect();
    }

    /**
     * gets mod details
     * 
     * @param int $id
     * 
     * @return array|false first contains mod data, false in case of error
     */
    public function getModDetails(int $id): array|false {
        $builder = $this->conn->table("mods");
        $builder->where("id", $id);

        if ($query = $builder->get()) {
            return $query->getResult();
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
    public function getModsByStatus(int $status): array|false {
        $builder = $this->conn->table("mods");
        $builder->where("is_approved", $status);

        if ($query = $builder->get()) {
            return $query->getResult();
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
    public function doesModNameExists(string $name): bool {
        $sql = "SELECT COUNT(*) FROM mods WHERE name = ?";
        $params = [$name];
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
     * deletes a mod row from the db
     * 
     * @param int $id
     * 
     * @return bool success status
     */
    public function deleteModFromDb(int $id): bool {
        $sql = "DELETE FROM mods WHERE id = ?";
        $params = [$id];

        if ($this->executeStmt($sql, $params)) {
            return true;
        }
        
        return false;
    }
}