<?php

namespace App\Models\Mod;

use Config\Database;
use CodeIgniter\Model;

class ModModel extends Model {

    protected $table = "mods";

    protected $useSoftDelete = true;

    protected $allowedFields = ["author", "name", "description", "version", "is_approved"];

    /**
     * gets the last uploaded mod id
     * 
     * @return int
     */
    public function getLastId(): int {
        $builder = $this->select("id")
                        ->orderBy("id", "DESC")
                        ->limit(1);

        if ($builder->countAllResults(false) > 0) {
            return $builder->get()->getRow()->id;
        }
        
        return 0;
    }

    /**
     * gets mod details
     * 
     * @param int $id
     * 
     * @return object|null
     */
    public function getModDetails(int $id): object|null {
        $builder = $this->select("*")
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
     * @return array|null
     */
    public function getModsByApprovedStatus(int $is_approved): array|null {
        $builder = $this->select("*")
                        ->where("is_approved", $is_approved);

        if ($builder->countAllResults(false) > 0) {
            return $builder->get()->getResult();
        }
        
        return null;
    }

    /**
     * update is_approve status to true
     * 
     * @param int $id
     */
    public function approveMod(int $id): void {
        $builder = $this->update($id, ['is_approved' => 1]);
    }

    /**
     * deletes a mod from the mods table
     * 
     * @param int $id
     */
    public function deleteMod(int $id): void {
        $builder = $this->delete(['id' => $id]);
    }
}