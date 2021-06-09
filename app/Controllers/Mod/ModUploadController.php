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
     * called on get request
     * shows the upload mod page only if the user is logged in
     */
    public function index(): void {
        $this->view();
    }

    /**
     * called on post request
     * tries to upload the mod, if it fails shows mod upload page with errors messages
     */
    public function uploadMod() {
        helper("form");

        if ($this->validate("mod")) {
            $modModel = new ModModel;

            $id = $modModel->getLastId() + 1;

            $file = $this->request->getFile("file");
            $image = $this->request->getFile("image");

            if ($file->isValid() && !$file->hasMoved()) {
                $file->move(WRITEPATH . "uploads/mods/" . $id, "file." . $file->getExtension());
            }

            if ($image->isValid() && !$image->hasMoved()) {
                $image->move(WRITEPATH . "uploads/mods/" . $id, "image." . $image->getExtension());
            }

            $data = array_merge($this->request->getPost(), ["author" => $this->session->uid]);
            $modModel->save($data);

            return redirect()->to("/");
        }

        $this->data['errors'] = $this->validator->listErrors();

        $this->view();
    }

    private function view(): void {
        echo view("templates/header", $this->data);
        echo view("mod/mod_upload");
        echo view("templates/footer");
    }
}
