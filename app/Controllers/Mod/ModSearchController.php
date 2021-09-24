<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;

class ModSearchController extends BaseController {

    private array $data = [
        "title" => "Results for ",
    ];

    public function search($query): void {
        $modModel = new ModModel();
        $this->data['mods'] = $modModel->search($query);
        $this->data['title'] .= esc($query);

        $this->view();
    }

    private function view(): void {
        echo view("templates/header", $this->data);
        echo view("mod/search");
        echo view("templates/footer");
    }
}
