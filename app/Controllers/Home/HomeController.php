<?php

namespace App\Controllers\Home;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;

class HomeController extends BaseController {

    private array $data = [
        "title" => "Home",
        "mods" => [],
    ];

    public function index(): void {
        $this->view();
    }

    public function search($query): void {
        $modModel = new ModModel();
        $this->data['mods'] = $modModel->search($query);

        $this->view();
    }

    private function view(): void {
        echo view("templates/header", $this->data);
        echo view("home/home");
        echo view("templates/footer");
    }
}
