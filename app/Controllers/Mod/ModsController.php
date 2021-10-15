<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ModsController extends BaseController {

    private array $data = [
        "title" => "Browse mods",
        "mods" => [],
    ];

    /**
     * shows the browse mods page
     */
    public function index(): void {
        $modModel = new ModModel;

        $uri = service("uri");
        $query = $uri->getQuery(['only' => 'order']);
        $order = explode("=", $query)[1];

        $this->data['mods'] = $modModel->getModsList(1, order: $order);

        echo view("mod/mods", $this->data);
    }
}
