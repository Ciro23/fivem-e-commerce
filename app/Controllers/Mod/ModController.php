<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;
use CodeIgniter\Exceptions\PageNotFoundException;

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
        $this->data['title'] = $this->data['mod']->name . " mod";

        $this->view();
    }

    private function view() {
        if ($this->data['mod'] === null) {
            throw new PageNotFoundException();
        }

        echo view("templates/header", $this->data);
        echo view("mod/mod");
        echo view("templates/footer");
    }
}
