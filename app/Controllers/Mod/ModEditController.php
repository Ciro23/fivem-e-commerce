<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;

class ModEditController extends BaseController {

    private array $data = [
        "title" => "Edit ",
    ];

    public function index(int $modId): void {
        $modModel = new ModModel();

        $this->data['mod'] = $modModel->getModDetails($modId);
        $this->data['title'] .= $this->data['mod']->name;

        echo view("mod/edit", $this->data);
    }
}
