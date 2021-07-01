<?php

namespace App\Controllers\Home;

use App\Controllers\BaseController;

class HomeController extends BaseController {

    private array $data = [
        "title" => "Home",
    ];

    public function index() {
        $this->view();
    }

    private function view() {
        view("templates/header", $this->data);
        view("home/home");
        view("templates/footer");
    }
}
