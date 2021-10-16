<?php

namespace App\Models\User;

use App\Libraries\RandomId;
use CodeIgniter\Model;

class UserModel extends Model {

    protected $table = "users";

    protected $useTimestamps = true;

    protected $useSoftDeletes = true;

    protected $allowedFields = ["email", "username", "description", "password", "avatar_ext"];

    protected $validationRules = "user";

    protected $beforeInsert = ["generateRandomId", "hashPassword"];

    /**
     * this method is called before every insert action invoked by this class
     * 
     * @param array $data
     * 
     * @return array
     */
    public function generateRandomId(array $data): array {
        $randomId = new RandomId();

        do {
            $data['data']['id'] = $randomId->generateRandomId();
        } while ($this->doesUserExist($data['data']['id']));

        return $data;
    }

    /**
     * this method is called before every insert action invoked by this class
     * 
     * @param array $data
     * 
     * @return array
     */
    public function hashPassword(array $data): array {
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);

        return $data;
    }

    /**
     * gets the user password given their email
     * 
     * @param string $email
     * 
     * @return string|null
     */
    public function getUserPasswordByEmail(string $email): string|null {
        $builder = $this->select("password");
        $builder->where("email", $email);

        if ($builder->countAllResults(false) === 1) {
            return $builder->get()->getRow()->password;
        }

        return null;
    }

    /**
     * checks if a user already exists
     * 
     * @param string $id
     * 
     * @return bool
     */
    public function doesUserExist(string $id): bool {
        $builder = $this->select("id");
        $builder->where("id", $id);

        return $builder->countAllResults() === 1;
    }

    /**
     * gets the user id by their email
     * 
     * @param string $email
     * 
     * @return string|null
     */
    public function getUserIdByEmail(string $email): string|null {
        $builder = $this->select("id");
        $builder->where("email", $email);

        if ($builder->countAllResults(false) === 1) {
            return $builder->get()->getRow()->id;
        }

        return null;
    }

    /**
     * gets the user details by their id
     * 
     * @param string $id
     * 
     * @return object|null
     */
    public function getUserDetails(string $id): object|null {
        $builder = $this->select();
        $builder->where("id", $id);

        if ($builder->countAllResults(false) === 1) {
            return $builder->get()->getRow();
        }

        return null;
    }

    /**
     * checks if the user is an admin
     * 
     * @param string $id
     * 
     * @return bool
     */
    public function isUserAdmin(string $id): bool {
        return $this->getUserRole($id) == 1;
    }

    /**
     * gets the user role by their id
     * 
     * @param string $id
     * 
     * @return int|null
     */
    public function getUserRole(string $id): int|null {
        $builder = $this->select("role");
        $builder->where("id", $id);

        if ($builder->countAllResults(false) == 1) {
            return $builder->get()->getRow()->role;
        }

        return null;
    }
}
