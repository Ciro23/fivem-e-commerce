<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {

    protected $table = "users";

    protected $useSoftDelete = true;

    protected $allowedFields = ["email", "username", "password"];

    protected $validationRules = ["signup"];

    protected $beforeInsert = ["hashPassword"];

    /**
     * signup a new user
     * 
     * @param array $data an associative array of insert values
     * 
     *  @return bool
     */
    public function signupNewUser(array $data): bool {
        return $this->db->table("users")
                        ->insert($data);
    }
    
    /**
     * hashes the user password with the bcrypt algorithm
     * 
     * @param array $data
     * 
     * @return array
     */
    public function hashPassword(array $data) {
        $data['data']['hashed_password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);

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
        $builder = $this->db->table("users")
                            ->select("password")
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

        $builder = $this->db->table("users")
                            ->select($field)
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
        $builder = $this->db->table("users")
                            ->select("id")
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
        $builder = $this->db->table("users")
                            ->select("role")
                            ->where("id", $id);

        $query = $builder->get();

        return $query->getRow()->role > 0;
    }
}
