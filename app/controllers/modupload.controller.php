<?php

class ModUploadController extends Mvc\Controller {

    /**
     * shows the upload mod page
     */
    public function index() {
        if (isset($_SESSION['uid'])) {
            // saves the error, the email if something goes wrong
            $data['form']['error'] = $_GET['error'] ?? "";
            $data['form']['name'] = $_GET['name'] ?? "";
            $data['form']['description'] = $_GET['description'] ?? "";
            $data['form']['version'] = $_GET['version'] ?? "";

            // formats the error
            $data['form']['error'] = SignupModel::formatError($data['form']['error']);

            $this->view("modupload", $data);
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
                . "&version="
                . $modModel->version
                . "&description="
                . $modModel->description);
        }
    }
}
