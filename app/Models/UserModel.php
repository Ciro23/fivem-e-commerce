<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {

    protected $table = "users";

    protected $useSoftDelete = true;

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
     * @return string
     */
    public function getUserPasswordByEmail(string $email): string {
        $builder = $this->select("password")
                        ->where("email", $email);
        
        $query = $builder->get();

        return $query->getRow()->password;
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

        $builder = $this->select($field)
                        ->where($field, $value)
                        ->countAllResults();

        return $builder > 0;
    }

    /**
     * gets the user id by their email
     * 
     * @param string $email
     * 
     * @return int
     */
    public function getUserIdByEmail(string $email): int {
        $builder = $this->select("id")
                        ->where("email", $email);

        $query = $builder->get();

        return $query->getRow()->id;
    }

    /**
     * checks if the user is an admin
     * 
     * @param int $id
     * 
     * @return bool
     */
    public function isUserAdmin(int $id): bool {
        if ($this->getUserRole($id) == 1) {
            return true;
        }
        return false;
    }

    /**
     * gets the user role by their id
     * 
     * @param int $id
     * 
     * @return bool
     */
    public function getUserRole(int $id): bool {
        $builder = $this->select("role")
                        ->where("id", $id);

        $query = $builder->get();

        return $query->getRow()->role > 0;
    }
}
