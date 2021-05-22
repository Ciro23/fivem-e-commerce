<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {

    /**
     * gets the user password given their email
     * 
     * @param string $email
     * 
     * @return string|false the email or false on failure
     */
    public function getUserPasswordByEmail(string $email): string|false {
        $sql = "SELECT password FROM users WHERE email = ?";
        $params = [$email];
        $query = $this->executeStmt($sql, $params);

        // tries to run the query
        if ($query) {
            return $query->fetch(PDO::FETCH_COLUMN);
        }
        
        return false;
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
     * @return int|false id in case of success, false otherwise
     */
    public function getUserIdByEmail(string $email): int|false {
        $sql = "SELECT id FROM users WHERE email = ?";
        $params = [$email];
        $query = $this->executeStmt($sql, $params);

        // tries to run the query
        if ($query) {
            return $query->fetch(PDO::FETCH_COLUMN);
        }
        
        return false;
    }

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
     * @return int|false role in case of success, false otherwise
     */
    public function getUserRole(int $id): int|false {
        $sql = "SELECT role FROM users WHERE id = ?";
        $params = [$id];
        $query = $this->executeStmt($sql, $params);

        // tries to run the query
        if ($query) {
            return $query->fetch(PDO::FETCH_COLUMN);
        }
        
        return false;
    }
}
