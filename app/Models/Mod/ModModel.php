<?php

namespace App\Models\Mod;

use App\Libraries\RandomId;
use CodeIgniter\Model;

class ModModel extends Model {

    protected $table = "mods";

    protected $useTimestamps = true;

    protected $useSoftDeletes = true;

    protected $allowedFields = ["id", "author", "name", "description", "price", "size", "is_approved", "file_ext", "logo_ext"];

    /**
     * generate a random alphanumeric string
     * 
     * @return string
     */
    public function generateRandomId(): string {
        $randomId = new RandomId();

        do {
            $id = $randomId->generateRandomId();
        } while ($this->doesModExist($id));

        return $id;
    }

    /**
     * checks whether a mod exists or not
     * 
     * @param string $id
     * 
     * @return bool
     */
    public function doesModExist(string $id): bool {
        $builder = $this->select("id");
        $builder->where("id", $id);

        return $builder->countAllResults() === 1;
    }

    /**
     * gets mod details
     * 
     * @param string $id
     * 
     * @return object|null
     */
    public function getModDetails(string $id): object|null {
        $builder = $this->select("mods.*, users.username as author_name");
        $builder->join("users", "mods.author = users.id");
        $builder->where("mods.id", $id);

        if ($builder->countAllResults(false)) {
            return $builder->get()->getRow();
        }

        return null;
    }

    /**
     * gets all mods filtered by their approved status and author
     * 
     * @param int $isApproved
     * @param string $authorId [optional]
     * @param string $order [optional]
     * 
     * @return array
     */
    public function getModsList(int $isApproved, string $authorId = null, string $order = "newer",): array {
        $orders = [
            "newer" => "desc",
            "older" => "asc",
        ];
        
        $builder = $this->select("mods.*, users.username as author_name");
        $builder->join("users", "mods.author = users.id");
        $builder->where("is_approved", $isApproved);
        $builder->orderBy("id", $orders[$order]);

        if ($authorId !== null) {
            $builder->where("mods.author", $authorId);
        }
        
        if ($builder->countAllResults(false) > 0) {
            return $builder->get()->getResult();
        }

        return [];
    }

    public function search(string $query): array {
        $builder = $this->select("mods.*, users.username as author_name");
        $builder->like("name", $query);
        $builder->join("users", "mods.author = users.id");
        $builder->where("is_approved", 1);

        if ($builder->countAllResults(false) > 0) {
            return $builder->get()->getResult();
        }

        return [];
    }

    /**
     * checks if the mod is approved or not
     * 
     * @param string $id
     * 
     * @return bool
     */
    public function isApproved(string $id): bool {
        return $this->getModDetails($id)->is_approved === "1";
    }

    /**
     * update is_approve status to true
     * 
     * @param string $id
     */
    public function approve(string $id): void {
        $builder = $this->update($id, ['is_approved' => 1]);
    }

    /**
     * deletes a mod from the mods table
     * 
     * @param string $id
     */
    public function remove(string $id): void {
        $builder = $this->delete(['id' => $id]);
    }
}
