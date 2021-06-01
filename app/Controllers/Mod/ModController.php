<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;

class ModController extends BaseController {
    
    private array $data = [
        "styles" => ["mod"],
        "title" => "",
        "mod" => null,
    ];

    /**
     * shows the mod page
     */
    public function index(int $modId): void {
        $modModel = new ModModel;

        // gets the mod data
        $this->data['mod'] = $modModel->getModDetails($modId);

        $this->view();
    }

    private function view() {
        if ($this->data['mod'] === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        echo view("templates/header", $this->data);
        echo view("mod/mod");
        echo view("templates/footer");
    }
}