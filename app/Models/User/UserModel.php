<?php

namespace App\Models\User;

use CodeIgniter\Model;

class UserModel extends Model {

    protected $table = "users";

    protected $useTimestamps = true;

    protected $useSoftDeletes = true;

    protected $allowedFields = ["email", "username", "password"];

    protected $validationRules = "user";

    protected $beforeInsert = ["hashPassword"];

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

        if ($builder->countAllResults(false)) {
            return $builder->get()->getRow()->password;
        }

        return null;
    }

    /**
     * checks if a user already exists given its username or email
     * 
     * @param string $field user email or username
     * @param string $value the value of the field
     * 
     * @return bool
     */
    public function doesUserExists(string $field, string $value): bool {
        // email and username are the only two primary key fields in the users table
        if (!in_array($field, ["email", "username"])) {
            return false;
        }

        $builder = $this->select($field);
        $builder->where($field, $value);
        $builder->countAllResults();

        return $builder > 0;
    }

    /**
     * gets the user id by their email
     * 
     * @param string $email
     * 
     * @return int|null
     */
    public function getUserIdByEmail(string $email): int|null {
        $builder = $this->select("id");
        $builder->where("email", $email);

        if ($builder->countAllResults(false) > 0) {
            return $builder->get()->getRow()->id;
        }

        return null;
    }

    /**
     * checks if the user is an admin
     * 
     * @param int $id
     * 
     * @return bool
     */
    public function isUserAdmin(int $id): bool {
        return $this->getUserRole($id) == 1;
    }

    /**
     * gets the user role by their id
     * 
     * @param int $id
     * 
     * @return int|null
     */
    public function getUserRole(int $id): int|null {
        $builder = $this->select("role");
        $builder->where("id", $id);

        if ($builder->countAllResults(false) > 0) {
            return $builder->get()->getRow()->role;
        }

        return null;
    }
}
