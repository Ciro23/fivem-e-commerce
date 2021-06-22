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
     * updates the mod status
     * 
     * @param int $modId
     * @param int $status (0 => rejected, 1 => pending, 2 => approved)
     */
    public function updateModStatus(int $modId, int $status): void {
        $modApproveModel = new ModApproveModel;
        $userModel = new UserModel;

        if ($modApproveModel->updateModStatus($modId, $status, $userModel)) {
            header("Location: /mod/" . $modId);
        } else {
            header("Location: /mod/"
                . $modId
                . "/?error="
                . $modApproveModel->getModApproveError());
        }
    }

    private function view() {
        echo view("templates/header", $this->data);
        echo view("mod/approve");
        echo view("templates/footer");
    }
}
