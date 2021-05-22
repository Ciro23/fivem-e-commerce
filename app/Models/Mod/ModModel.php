<?php

namespace App\Models\Mod;

use Config\Database;
use CodeIgniter\Model;

class ModModel extends Model {

    /**
     * gets mod details
     * 
     * @param int $id
     * 
     * @return object|null first contains mod data, false in case of error
     */
    public function getModDetails(int $id): object|null {
        $builder = $this->db->table("mods")
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
        $builder = $this->db->table("mods")
                            ->select("*")
                            ->where("is_approved", $is_approved);

        $query = $builder->get();
        
        return $query->getResult();
    }

    /**
     * deletes a mod from the mods table
     * 
     * @param int $id
     */
    public function deleteModFromDb(int $id): void {
        $builder = $this->db->table("mods");
        $builder->where("id", $id);
        $builder->delete();
    }
}