<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;
use App\Models\Mod\ModUploadModel;

class ModUploadController extends BaseController {

    /**
     * shows the upload mod page only if the user is logged in
     */
    public function index(): void {
        echo view("mod/mod_upload");
    }

    public function uploadMod(): void {
        $modUploadModel = new ModUploadModel;
        $modModel = new ModModel;

        // tries to execute ModUpload::upload(), which returns true in case of success, false otherwise
        if ($modUploadModel->uploadMod([$_POST, $_FILES], $modModel)) {
            header("Location: /");
        } else {
            header("Location: /mod/upload/?error="
                . $modUploadModel->getModUploadError()
                . "&name="
                . $modUploadModel->getModName()
                . "&version="
                . $modUploadModel->getModVersion()
                . "&description="
                . $modUploadModel->getModDescription());
        }
    }
}
