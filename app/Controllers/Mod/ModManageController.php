<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;

class ModManageController extends BaseController {

    private array $data = [
        "title" => "Approve mods",
    ];

    /**
     * shows the mod approve page only if the user is admin
     */
    public function index(): void {
        helper("text");

        $modModel = new ModModel();
        $this->data['mods'] = $modModel->getModsByApprovedStatus(0);

        echo $this->view();
    }

    /**
     * update is_approved status to true
     * 
     * @param int $modId
     */
    public function approve($modId) {
        $modModel = new ModModel();
        $modModel->approveMod($modId);

        return redirect()->to("/mod/" . $modId);
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

        $modFilesPath = WRITEPATH . "uploads/mods_files/" . $modId;
        $modImagePath = ROOTPATH . "/public/assets/mods_images/" . $modId;

        delete_files($modFilesPath);
        delete_files($modImagePath);

        // deletes the empty mod folders
        rmdir($modFilesPath);
        rmdir($modImagePath);

        return redirect("manage_mods");
    }

    private function view() {
        echo view("templates/header", $this->data);
        echo view("mod/manage");
        echo view("templates/footer");
    }
}
