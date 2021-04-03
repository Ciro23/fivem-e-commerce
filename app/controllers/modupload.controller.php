<?php

class ModUploadController extends Mvc\Controller {

    /**
     * shows the upload mod page
     */
    public function index() {
        if (isset($_SESSION['uid'])) {
            // saves the error, and all the form data if something goes wrong
            $data['form']['error'] = $_GET['error'] ?? "";
            $data['form']['name'] = $_GET['name'] ?? "";
            $data['form']['description'] = $_GET['description'] ?? "";
            $data['form']['version'] = $_GET['version'] ?? "";

            // formats the error
            $data['form']['error'] = StringHelper::formatError($data['form']['error']);

            $this->view("modupload", $data);
        } else {
            header("Location: /login");
        }
    }

    /**
     * performs the upload action
     */
    public function upload() {
        $modUploadModel = $this->model("ModUpload");
        $modModel = $this->model("Mod");

        // tries to upload the mod
        if ($modUploadModel->upload($modModel)) {
            header("Location: /");
        } else {
            header("Location: /mod/upload/?error="
                . $modUploadModel->error
                . "&name="
                . $modUploadModel->data['name']
                . "&version="
                . $modUploadModel->data['version']
                . "&description="
                . $modUploadModel->data['description']);
        }
    }
}
