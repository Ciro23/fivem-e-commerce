<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ModsController extends BaseController {

    private array $data = [
        "title" => "Browse mods",
        "mods" => [],
    ];

    /**
     * shows the browse mods page
     */
    public function index(): void {
        $modModel = new ModModel;

        $this->data['mods'] = $modModel->getModsList(1);

        echo view("mod/mods", $this->data);
    }
}
