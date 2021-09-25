<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ModController extends BaseController {

    private array $data = [
        "title" => "",
        "mod" => null,
    ];

    /**
     * shows the mod page
     */
    public function index(int $modId): void {
        $modModel = new ModModel;

        $this->data['mod'] = $modModel->getModDetails($modId);

        if ($this->data['mod'] === null) {
            throw new PageNotFoundException();
        }

        $this->data['title'] = $this->data['mod']->name . " mod";

        echo view("mod/mod", $this->data);
    }
}
