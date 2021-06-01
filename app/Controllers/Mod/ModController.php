<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;

class ModController extends BaseController {
    
    /**
     * shows the mod page
     */
    public function index(int $modId): void {
        $modModel = new ModModel;

        // gets the mod data
        $data['mod'] = $modModel->getModDetails($modId);

        $this->view($data);
    }

    private function view($data) {
        if ($data['mod'] === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        echo view("mod/mod", $data);
    }
}