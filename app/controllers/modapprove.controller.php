<?php

class ModApproveController extends Mvc\Controller {
    
    /**
     * updates the mod status
     * 
     * @param int $modId
     * @param int $status (0 => rejected, 1 => pending, 2 => approved)
     */
    public function updateStatus($modId, $status) {
        $modApproveModel = $this->model("ModApprove");

        if ($modApproveModel->updateStatus($modId, $status)) {
            header("Location: /mod/" . $modId);
        } else {
            header("Location: /mod/" . $modId . "/?error=" . $modApproveModel->error);
        }
    }
}