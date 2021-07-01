<?php

namespace Unit\Models;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\Mod\ModModel;

class ModModelTest extends CIUnitTestCase {

    private object $mod;

    protected function setUp(): void {
        $this->mod = new ModModel();
    }

    public function test_does_mod_exist() {
        $doesExist = $this->mod->doesModExist(2);

        $this->assertTrue($doesExist);
    }

    public function test_does_non_existent_mod_exist() {
        $doesExist = $this->mod->doesModExist(1);

        $this->assertFalse($doesExist);
    }

    public function test_get_mod_details() {
        $details = $this->mod->getModDetails(3);

        $this->assertIsObject($details);
    }

    public function test_get_non_existent_mod_details() {
        $details = $this->mod->getModDetails(1);

        $this->assertNull($details);
    }

    public function test_get_mods_by_approved_status() {
        $mods = $this->mod->getModsByApprovedStatus(1);

        $this->assertIsArray($mods);
    }

    public function test_get_mods_by_wrong_approved_status() {
        $mods = $this->mod->getModsByApprovedStatus(2);

        $this->assertSame([], $mods);
    }

    public function test_is_approved() {
        $isApproved = $this->mod->isApproved(3);

        $this->assertEquals(1, $isApproved);
    }

    public function test_is_not_approved() {
        $response = $this->mod->isApproved(2);

        $this->assertEquals(0, $response);
    }
}
