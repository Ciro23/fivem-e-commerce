<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;

class ModManageController extends BaseController {

    private array $data = [
        "styles" => ["mod_approve"],
        "title" => "Approve mods",
    ];

    /**
     * shows the mod approve page only if the user is admin
     */
    public function index(): void {
        $modModel = new ModModel();
        $this->data['mods'] = $modModel->getModsByApprovedStatus(0);

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
     * deletes the specified mod
     * 
     * @param int $modId
     */
    public function deny($modId) {
        helper("filesystem");

        // deletes the mod from the db
        $modModel = new ModModel();
        $modModel->deleteMod($modId);

        $modFilesPath = WRITEPATH . "uploads/mods/" . $modId;

        // deletes all the files inside the mod folder
        delete_files($modFilesPath);

        // deletes the empty mod folder
        rmdir($modFilesPath);
    }

    private function view() {
        echo view("templates/header", $this->data);
        echo view("mod/approve");
        echo view("templates/footer");
    }
}
