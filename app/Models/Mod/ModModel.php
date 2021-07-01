<?php

namespace App\Models\Mod;

use CodeIgniter\Model;

class ModModel extends Model {

    protected $table = "mods";

    protected $useTimestamps = true;

    protected $useSoftDeletes = true;

    protected $allowedFields = ["author", "name", "description", "price", "size", "is_approved", "file_ext", "image_ext"];

    /**
     * gets the last uploaded mod id
     * 
     * @return int
     */
    public function getLastId(): int {
        $query = $this->db->query("select id from mods order by id desc limit 1");

        if ($query->getNumRows() > 0) {
            return $query->getRow()->id;
        }

        return 0;
    }

    /**
     * checks whether a mod exists or not
     * 
     * @param int $id
     * 
     * @return bool
     */
    public function doesModExist(int $id) {
        $builder = $this->select("id");
        $builder->where("id", $id);

        return $builder->countAllResults() == 1;
    }

    /**
     * gets mod details
     * 
     * @param int $id
     * 
     * @return object|null
     */
    public function getModDetails(int $id): object|null {
        $builder = $this->select("mods.*, users.username as author_name");
        $builder->join("users", "mods.author = users.id");
        $builder->where("mods.id", $id);

        if ($builder->countAllResults(false)) {
            return $builder->get()->getRow();
        }

        return null;
    }

    /**
     * gets all mods based on whether they are approved or not
     * 
     * @param int $is_approved
     * 
     * @return array
     */
    public function getModsByApprovedStatus(int $is_approved): array {
        $builder = $this->select("mods.*, users.username as author_name");
        $builder->join("users", "mods.author = users.id");
        $builder->where("is_approved", $is_approved);

        if ($builder->countAllResults(false)) {
            return $builder->get()->getResult();
        }

        return [];
    }

    /**
     * returns 1 if the mod is approved, 0 otherwise
     * 
     * @param int $id
     * 
     * @return int
     */
    public function isApproved(int $id): int {
        $builder = $this->select("is_approved");
        $builder->where("id", $id);

        if ($builder->countAllResults(false)) {
            return $builder->get()->getRow()->is_approved;
        }

        return 0;
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
