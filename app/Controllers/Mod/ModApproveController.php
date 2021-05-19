<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;
use App\Models\Mod\ModApproveModel;
use App\Models\UserModel;

class ModApproveController extends BaseController {

    /**
     * shows the mod approve page only if the user is admin
     */
    public function index(): void {
        $userModel = new UserModel;

        // shows the page only if the user is an admin
        if (
            isset($_SESSION['uid'])
            && $userModel->isUserAdmin($_SESSION['uid'])
        ) {
            // gets the list of mods to approve
            $modModel = new ModModel;
            $data['mods'] = $modModel->getModsByStatus(1);

            // saves the admin status
            $data['user']['is_admin'] = true;

            echo view("modapprove", $data);
        } else {
            echo view("pagenotfound");
        }
    }

    /**
     * updates the mod status
     * 
     * @param int $modId
     * @param int $status (0 => rejected, 1 => pending, 2 => approved)
     */
    public function updateModStatus(int $modId, int $status): void {
        $modApproveModel = new ModApproveModel;
        $userModel = new UserModel;

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
