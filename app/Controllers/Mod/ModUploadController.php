<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;

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

            $fileExt = $file->getExtension();
            $imageExt = $image->getExtension();

            $fileSize = $file->getSize();

            if ($file->isValid() && !$file->hasMoved()) {
                $file->move(WRITEPATH . "uploads/mods_files/" . $id, "file." . $fileExt);
            }

            if ($image->isValid() && !$image->hasMoved()) {
                $image->move(ROOTPATH . "/public/assets/mods_images/" . $id, "image." . $imageExt);
            }

            $additionalData = [
                "author" => $this->session->uid,
                "size" => $fileSize,
                "file_ext" => $fileExt,
                "image_ext" => $imageExt,
            ];

            $data = array_merge($this->request->getPost(), $additionalData);
            $modModel->save($data);

            return redirect()->to("/");
        }

        $this->data['errors'] = $this->validator->listErrors();

        $this->view();
    }

    private function view(): void {
        echo view("templates/header", $this->data);
        echo view("mod/upload");
        echo view("templates/footer");
    }
}
