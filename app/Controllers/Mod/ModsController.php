<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ModsController extends BaseController {

    protected array $data = [
        "title" => "Browse mods",
        "mods" => [],
        "selected_order" => "newer",
        "orders" => [
            "newer",
            "older",
        ]
    ];

    /**
     * shows the browse mods page
     */
    public function index(): void {
        $modModel = new ModModel;

        $uri = service("uri");
        $query = $uri->getQuery(['only' => 'order']);

        if ($query !== "") {
            $this->data['selected_order'] = explode("=", $query)[1];
        }

        $this->data['mods'] = $modModel->getModsList(1, order: $this->data['selected_order']);

        echo view("mod/mods", $this->data);
    }
}
