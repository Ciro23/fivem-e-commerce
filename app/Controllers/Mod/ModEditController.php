<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;

class ModEditController extends BaseController {

    private array $data = [
        "title" => "Edit mod",
    ];

    public function index() {
        echo view("mod/edit", $this->data);
    }
}
