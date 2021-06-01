<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;
use App\Models\Mod\ModUploadModel;

class ModUploadController extends BaseController {

    private array $data = [
        "styles" => ["form_page"],
        "title" => "Upload a mod",
    ];

    /**
     * shows the upload mod page only if the user is logged in
     */
    public function index(): void {
        echo view("templates/header", $this->data);
        echo view("mod/mod_upload");
        echo view("templates/footer");
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
