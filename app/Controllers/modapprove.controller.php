<?php

class ModApproveController extends Mvc\Controller {

    /**
     * shows the mod approve page only if the user is admin
     */
    public function index(): void {
        $userModel = $this->model("User");

        // shows the page only if the user is an admin
        if (
            isset($_SESSION['uid'])
            && $userModel->isUserAdmin($_SESSION['uid'])
        ) {
            // gets the list of mods to approve
            $modModel = $this->model("Mod");
            $data['mods'] = $modModel->getModsByStatus(1);

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
    public function updateModStatus(int $modId, int $status): void {
        $modApproveModel = $this->model("ModApprove");
        $userModel = $this->model("User");

        if ($modApproveModel->updateModStatus($modId, $status, $userModel)) {
            header("Location: /mod/" . $modId);
        } else {
            header("Location: /mod/"
                . $modId
                . "/?error="
                . $modApproveModel->getModApproveError());
        }
    }
}
