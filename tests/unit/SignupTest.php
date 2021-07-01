<?php

namespace Unit;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\User\UserModel;

class SignupTest extends CIUnitTestCase {

    public function test_save() {
        helper("text");

        $model = new UserModel();

        $data = [
            "email" => random_string("alnum") . "@test.com",
            "username" => random_string("alnum"),
            "password" => "asdasd",
            "confirm_password" => "asdasd",
        ];

        $response = $model->save($data);

        $this->assertTrue($response);
    }
}
