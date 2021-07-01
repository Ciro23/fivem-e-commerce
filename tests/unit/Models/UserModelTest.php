<?php

namespace Unit\Models;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\User\UserModel;

class UserModelTest extends CIUnitTestCase {

    private object $userModel;

    protected function setUp(): void {
        $this->userModel = new UserModel();
    }

    public function test_get_id() {
        $id = $this->userModel->getUserIdByEmail("prova@prova.it");

        $this->assertSame(2, $id);
    }

    public function test_get_user_password_by_email() {
        $password = $this->userModel->getUserPasswordByEmail("asd@gmail.com");

        $this->assertSame("$2y$10$2EkxQ4UVshXbmAB.im2jNuHwNSbH9haVwoEJVZfZKS/QDkIiUVaEu", $password);
    }

    public function test_get_user_password_by_wrong_email() {
        $password = $this->userModel->getUserPasswordByEmail("doesntexist@xxx.it");

        $this->assertNull($password);
    }

    public function test_does_user_exists_correct_email() {
        $response = $this->userModel->doesUserExists("email", "prova@prova.it");

        $this->assertTrue($response);
    }

    public function test_does_user_exists_wrong_email() {
        $response = $this->userModel->doesUserExists("email", "a.caso@casaccio.it");

        $this->assertFalse($response);
    }

    public function test_does_user_exists_correct_username() {
        $response = $this->userModel->doesUserExists("username", "asdasd");

        $this->assertTrue($response);
    }

    public function test_does_user_exists_wrong_username() {
        $response = $this->userModel->doesUserExists("username", "username_doesnt_exist_xxx");

        $this->assertFalse($response);
    }

    public function test_does_user_exists_wrong_field() {
        $response = $this->userModel->doesUserExists("xxx", "random@random.xxx.it");

        $this->assertFalse($response);
    }

    public function test_get_user_id_by_correct_email() {
        $id = $this->userModel->getUserIdByEmail("asd@gmail.com");

        $this->assertSame(1, $id);
    }

    public function test_get_user_id_by_wrong_email() {
        $id = $this->userModel->getUserIdByEmail("doesntexist@xxx.it");

        $this->assertNull($id);
    }

    public function test_is_user_admin() {
        $response = $this->userModel->isUserAdmin(1);

        $this->assertTrue($response);
    }

    public function test_is_unexistent_user_admin() {
        $response = $this->userModel->isUserAdmin(0);

        $this->assertFalse($response);
    }

    public function test_get_user_role_admin() {
        $role = $this->userModel->getUserRole(1);

        $this->assertSame(1, $role);
    }

    public function test_get_user_role_normal_user() {
        $role = $this->userModel->getUserRole(3);

        $this->assertSame(0, $role);
    }

    public function test_get_non_existent_user_role() {
        $role = $this->userModel->getUserRole(0);

        $this->assertNull($role);
    }
}
