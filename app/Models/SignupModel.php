<?php

namespace App\Models;

use CodeIgniter\Model;

class SignupModel extends Model {

    private array $userData = [
        "email" => "",
        "username" => "",
        "password" => "",
        "rePassword" => ""
    ];

    /**
     * gets the input, hashes the password and insert the data into the db
     * 
     * @param array $inputData
     */
    public function signup(array $inputData): void {
        // gets the form input
        $this->userData = \InputHelper::getFormInput($this->userData, $inputData);

        // hashes the password
        $this->userData['password'] = password_hash($this->userData['password'], PASSWORD_BCRYPT);

        $data = [
            "email" => $this->userData['email'],
            "username" => $this->userData['username'],
            "password" => $this->userData['password']
        ];
        
        $this->insertIntoDb($data);
    }

    /**
     * creates a new row in the users table
     * 
     * @param array $data
     */
    private function insertIntoDb(array $data): void {
        $builder = $this->db->table("users")
                            ->insert($data);
    }
}
