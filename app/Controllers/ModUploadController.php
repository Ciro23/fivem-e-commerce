<?php

namespace App\Controllers;

use App\Models\ModModel;
use App\Models\ModUploadModel;

class ModUploadController extends BaseController {

    /**
     * shows the upload mod page only if the user is logged in
     */
    public function index(): void {
        if (isset($_SESSION['uid'])) {
            // saves the error, and all the form data if something goes wrong
            $data['form']['error'] = $_GET['error'] ?? "";
            $data['form']['name'] = $_GET['name'] ?? "";
            $data['form']['description'] = $_GET['description'] ?? "";
            $data['form']['version'] = $_GET['version'] ?? "";

            // formats the error
            $data['form']['error'] = StringHelper::formatError($data['form']['error']);

            echo view("modupload", $data);
        } else {
            header("Location: /login");
        }
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
