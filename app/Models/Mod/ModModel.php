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
     * @return object|null first contains mod data, false in case of error
     */
    public function getModDetails(int $id): object|null {
        $builder = $this->conn->table("mods")
                              ->select("*")
                              ->where("id", $id);

        $query = $builder->get();

        return $query->getRow();
    }

    /**
     * gets all mods based on whether they are approved or not
     * 
     * @param int $is_approved
     * 
     * @return array
     */
    public function getModsByApprovedStatus(int $is_approved): array {
        $builder = $this->conn->table("mods")
                              ->select("*")
                              ->where("is_approved", $is_approved);

        $query = $builder->get();
        
        return $query->getResult();
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