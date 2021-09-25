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
        $this->data['title'] .= $query;
        $this->data['query'] = $query;

        echo view("mod/search", $this->data);
    }
}
