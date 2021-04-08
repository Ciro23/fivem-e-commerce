<?php

class ModApproveController extends Mvc\Controller {

    /**
     * shows the mod approve page only if the user is admin
     */
    public function index() {
        $userModel = $this->model("User");

        // shows the page only if the user is an admin
        if (
            isset($_SESSION['uid'])
            && $userModel->isAdmin($_SESSION['uid'])
        ) {
            // gets the list of mods to approve
            $modModel = $this->model("Mod");
            $data['mods'] = $modModel->getList(1);

            // saves the admin status
            $data['user']['is_admin'] = true;

            $this->view("modapprove", $data);
        } else {
            $this->view("pagenotfound");
        }
    }

    /**
     * updates the mod status
     * 
     * @param int $modId
     * @param int $status (0 => rejected, 1 => pending, 2 => approved)
     */
    public function updateStatus($modId, $status) {
        $modApproveModel = $this->model("ModApprove");
        $userModel = $this->model("User");

        if ($modApproveModel->updateStatus($modId, $status, $userModel)) {
            header("Location: /mod/" . $modId);
        } else {
            header("Location: /mod/"
                . $modId
                . "/?error="
                . $modApproveModel->getError());
        }
    }
}
