<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;

class ModEditController extends BaseController {

    private array $data = [
        "title" => "Edit mod",
    ];

    public function index(int $modId): void {
        $modModel = new ModModel();

        $this->data['mod'] = $modModel->getModDetails($modId);

        echo view("mod/edit", $this->data);
    }
}
