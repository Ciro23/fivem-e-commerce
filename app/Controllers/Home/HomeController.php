<?php

namespace App\Controllers\Home;

use CodeIgniter\Controller;

class HomeController extends Controller {

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
