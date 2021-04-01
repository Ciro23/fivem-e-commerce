<?php

class ModController extends Mvc\Controller {

    /**
     * performs the upload action
     */
    public function upload() {
        $modModel = $this->model("mod");

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
