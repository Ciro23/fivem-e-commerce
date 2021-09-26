<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;

class ModEditController extends BaseController {

    private array $data = [
        "title" => "Edit ",
    ];

    public function index(int $modId): void {
        $modModel = new ModModel();

        $this->data['mod'] = $modModel->getModDetails($modId);
        $this->data['title'] .= $this->data['mod']->name;

        echo view("mod/edit", $this->data);
    }

    public function editMod(int $modId) {
        helper("form");

        if ($this->validate("mod_edit")) {
            $modModel = new ModModel;
            $modDetails = $modModel->getModDetails($modId);

            $file = $this->request->getFile("file");
            $image = $this->request->getFile("image");

            // if no file or image is uploaded, keep the old ones
            $fileExt = $modDetails->file_ext;
            $fileSize = $modDetails->size;
            $imageExt = $modDetails->image_ext;

            if ($file->isValid() && !$file->hasMoved()) {
                $fileExt = $file->getExtension();
                $fileSize = $file->getSize();

                $file->move(WRITEPATH . "uploads/mods_files/" . $modId, "file." . $fileExt);
            }

            if ($image->isValid() && !$image->hasMoved()) {
                $imageExt = $image->getExtension();

                $image->move(ROOTPATH . "/public/assets/mods_images/" . $modId, "image." . $imageExt);
            }

            $additionalData = [
                "size" => $fileSize,
                "file_ext" => $fileExt,
                "image_ext" => $imageExt,
            ];

            $data = array_merge($this->request->getPost(), $additionalData);
            $modModel->update($modDetails->id, $data);

            return redirect("home");
        }

        $this->data['errors'] = $this->validator->listErrors("custom_errors");

        $this->index($modId);
    }
}
