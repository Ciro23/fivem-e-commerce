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
     * @return object|null
     */
    public function getModDetails(int $id): object|null {
        $builder = $this->db->table("mods")
                            ->select("*")
                            ->where("id", $id);

        if ($builder->countAllResults(false) > 0) {
            return $builder->get()->getRow();
        }
        
        return null;
    }

    /**
     * gets all mods based on whether they are approved or not
     * 
     * @param int $is_approved
     * 
     * @return object|null
     */
    public function getModsByApprovedStatus(int $is_approved): object|null {
        $builder = $this->db->table("mods")
                            ->select("*")
                            ->where("is_approved", $is_approved);

        if ($builder->countAllResults(false) > 0) {
            return $builder->get()->getResult();
        }
        
        return null;
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