<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\User\UserModel;

class UserEditController extends BaseController {

    private array $data = [
        "title" => "Edit ",
    ];

    public function index(int $uid): void {
        $userModel = new UserModel();

        $this->data['user'] = $userModel->getUserDetails($uid);

        echo view("user/edit", $this->data);
    }

    public function editMod(int $uid) {
        helper("form");

        if ($this->validate("user_edit")) {
            $userModel = new UserModel;
            $modDetails = $userModel->getUserDetails($uid);

            $file = $this->request->getFile("file");
            $image = $this->request->getFile("image");

            // if no file or image is uploaded, keep the old ones
            $fileExt = $modDetails->file_ext;
            $fileSize = $modDetails->size;
            $imageExt = $modDetails->image_ext;

            if ($file->isValid() && !$file->hasMoved()) {
                $fileExt = $file->getExtension();
                $fileSize = $file->getSize();

                $file->move(WRITEPATH . "uploads/mods_files/" . $uid, "file." . $fileExt);
            }

            if ($image->isValid() && !$image->hasMoved()) {
                $imageExt = $image->getExtension();

                $image->move(ROOTPATH . "/public/assets/mods_images/" . $uid, "image." . $imageExt);
            }

            $additionalData = [
                "size" => $fileSize,
                "file_ext" => $fileExt,
                "image_ext" => $imageExt,
            ];

            $data = array_merge($this->request->getPost(), $additionalData);
            $userModel->update($modDetails->id, $data);

            return redirect("home");
        }

        $this->data['errors'] = $this->validator->listErrors("custom_errors");

        $this->index($uid);
    }
}
