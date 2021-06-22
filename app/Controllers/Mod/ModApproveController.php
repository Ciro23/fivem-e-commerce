<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;
use App\Models\Mod\ModApproveModel;
use App\Models\UserModel;

class ModApproveController extends BaseController {

    private array $data = [
        "styles" => ["mod_approve"],
        "title" => "Approve mods",
    ];

    /**
     * shows the mod approve page only if the user is admin
     */
    public function index(): void {
        echo $this->view();
    }

    /**
     * update is_approved status to true
     * 
     * @param int $modId
     */
    public function approve($modId): void {
        $modModel = new ModModel();
        $modModel->approveMod($modId);
    }

    /**
     * soft deletes the specified mod
     * 
     * @param int $modId
     */
    public function deny($modId) {
        $modModel = new ModModel();
        $modModel->deleteMod($modId);
    }

    private function view() {
        echo view("templates/header", $this->data);
        echo view("mod/approve");
        echo view("templates/footer");
    }
}
