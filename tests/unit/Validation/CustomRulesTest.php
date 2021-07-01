<?php

namespace Unit\Validation;

use CodeIgniter\Test\CIUnitTestCase;
use App\Validation\UserRules;

class CustomRulesTest extends CIUnitTestCase {

    public function test_are_credentials_correct() {
        $obj = new UserRules;
        $response = $obj->are_credentials_correct("prova@prova.it", "prova", ['email' => 'prova@prova.it', 'password' => 'asdasd']);

        $this->assertTrue($response);
    }
}
