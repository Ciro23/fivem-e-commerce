<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;

class ModEditController extends BaseController {

    protected array $data = [
        "title" => "Edit ",
    ];

    public function index(string $modId): void {
        $modModel = new ModModel();

        $this->data['mod'] = $modModel->getModDetails($modId);
        $this->data['title'] .= $this->data['mod']->name;

        echo view("mod/edit", $this->data);
    }

    public function editMod(string $modId) {
        helper("form");

        if ($this->validate("mod_edit")) {
            $modModel = new ModModel;
            $modDetails = $modModel->getModDetails($modId);

            $file = $this->request->getFile("file");
            $logo = $this->request->getFile("logo");

            // if no file or logo is uploaded, keep the old ones
            $fileExt = $modDetails->file_ext;
            $fileSize = $modDetails->size;
            $logoExt = $modDetails->logo_ext;

            if ($file->isValid() && !$file->hasMoved()) {
                $fileExt = $file->getExtension();
                $fileSize = $file->getSize();

                $file->move(WRITEPATH . "uploads/mods_files/" . $modId, "file." . $fileExt);
            }

            if ($logo->isValid() && !$logo->hasMoved()) {
                $logoExt = $logo->getExtension();

                $logo->move(ROOTPATH . "/public/assets/mods_images/" . $modId, "logo." . $logoExt);
            }

            $additionalData = [
                "size" => $fileSize,
                "file_ext" => $fileExt,
                "logo_ext" => $logoExt,
            ];

            $data = array_merge($this->request->getPost(), $additionalData);
            $modModel->update($modDetails->id, $data);

            return redirect("home");
        }

        $this->data['errors'] = $this->validator->listErrors("custom_errors");

        $this->index($modId);
    }
}
