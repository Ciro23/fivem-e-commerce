<?php

namespace App\Controllers\Home;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;

class HomeController extends BaseController {

    private array $data = [
        "title" => "Home",
        "mods" => [],
    ];

    public function index() {
        $this->view();
    }

    public function search($query) {
        $modModel = new ModModel();
        $this->data['mods'] = $modModel->search($query);

        $this->view();
    }

    private function view() {
        view("templates/header", $this->data);
        view("home/home");
        view("templates/footer");
    }
}
