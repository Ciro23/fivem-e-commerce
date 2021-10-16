<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;
use CodeIgniter\HTTP\RedirectResponse;

class ModManageController extends BaseController {

    protected array $data = [
        "title" => "Approve mods",
        "mods" => null,
    ];

    /**
     * shows the mod approve page only if the user is admin
     */
    public function index(): void {
        $modModel = new ModModel();
        $this->data['mods'] = $modModel->getModsList(0);

        echo view("mod/manage", $this->data);
    }

    /**
     * update is_approved status to true
     * 
     * @param string $modId
     */
    public function approve(string $modId): RedirectResponse {
        $modModel = new ModModel();
        $modModel->approve($modId);

        return redirect("manage_mods");
    }

    /**
     * deletes the specified mod
     * 
     * @param string $modId
     */
    public function deny(string $modId): RedirectResponse {
        helper("filesystem");

        // deletes the mod from the db
        $modModel = new ModModel();
        $modModel->remove($modId);

        $this->deleteModFiles($modId);

        return redirect("manage_mods");
    }

    /**
     * deletes all the mod files from the disk
     * 
     * @param int $modId
     */
    private function deleteModFiles(int $modId): void {
        $modFilesPath = WRITEPATH . "uploads/mods_files/" . $modId;
        $modImagePath = ROOTPATH . "/public/assets/mods_images/" . $modId;

        delete_files($modFilesPath);
        delete_files($modImagePath);

        // deletes the empty mod folders
        rmdir($modFilesPath);
        rmdir($modImagePath);
    }
}
