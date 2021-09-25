<?php

namespace App\Controllers\Home;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;

class HomeController extends BaseController {

    private array $data = [
        "title" => "Home",
    ];

    public function index(): void {
        echo view("home/home", $this->data);
    }
}
