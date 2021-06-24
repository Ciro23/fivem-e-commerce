<?php

namespace App\Models\Mod;

use CodeIgniter\Model;

class ModModel extends Model {

    protected $table = "mods";

    protected $useTimestamps = true;

    protected $useSoftDeletes = true;

    protected $allowedFields = ["author", "name", "description", "price", "version", "is_approved", "file_ext", "image_ext"];

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
        $builder = $this->select("mods.*, users.username as author_name")
                        ->join("users", "mods.author = users.id")
                        ->where("id", $id);

        return $builder->get()->getRow();
    }

    /**
     * gets all mods based on whether they are approved or not
     * 
     * @param int $is_approved
     * 
     * @return array
     */
    public function getModsByApprovedStatus(int $is_approved): array {
        $builder = $this->select("mods.*, users.username as author_name")
                        ->where("is_approved", $is_approved)
                        ->join("users", "mods.author = users.id");

        return $builder->get()->getResult();
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