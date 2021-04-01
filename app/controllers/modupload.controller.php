<?php

class ModUploadController extends Mvc\Controller {

    /**
     * shows the upload mod page
     */
    public function index() {
        if (isset($_SESSION['uid'])) {
            $this->view("modupload");
        } else {
            header("Location: /login");
        }
    }

    /**
     * performs the upload action
     */
    public function upload() {
        $modModel = $this->model("ModUpload");

        // tries to upload the mod
        if ($modModel->upload()) {
            header("Location: /");
        } else {
            header("Location: /mod/upload/?error="
                . $modModel->error
                . "&name="
                . $modModel->name
                . "&description="
                . $modModel->description
                . "&version="
                . $modModel->version);
        }
    }
}
