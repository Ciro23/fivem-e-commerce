<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;
use App\Models\User\UserModel;

class ModUploadController extends BaseController {

    private array $data = [
        "title" => "Upload a mod",
    ];

    /**
     * called on get request
     * shows the upload mod page only if the user is logged in
     */
    public function index(): void {
        echo view("mod/upload", $this->data);
    }

    /**
     * called on post request
     * tries to upload the mod, if it fails shows mod upload page with errors messages
     */
    public function uploadMod() {
        helper("form");

        if ($this->validate("mod")) {
            $modModel = new ModModel;
            $userModel = new UserModel();

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
                "is_approved" => $userModel->isUserAdmin($this->session->uid) ? 1 : 0,
            ];

            $data = array_merge($this->request->getPost(), $additionalData);
            $modModel->save($data);

            return redirect("home");
        }

        // save the user input and errors
        $this->data['mod'] = (object)$this->request->getPost();
        $this->data['errors'] = $this->validator->listErrors("custom_errors");

        $this->index();
    }
}
