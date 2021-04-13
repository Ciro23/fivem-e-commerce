<?php

class ModApproveModel extends Mvc\Model {

    /**
     * @var string $modApproveError
     */
    private $modApproveError = "";

    /**
     * @var array $data
     */
    private $data = [
        "mod_id" => "",
        "status" => ""
    ];

    private $allowedStatuses = [0, 1, 2];

    /**
     * returns the error
     * 
     * @return error
     */
    public function getModApproveError() {
        return $this->modApproveError;
    }

    /**
     * updates the mod status
     * 
     * @param int $modId
     * @param int $status (0 => rejected, 1 => pending, 2 => approved)
     * @param object $userModel
     * 
     * @return bool success status
     */
    public function updateStatus($modId, $status, $userModel) {
        // saves the mod id and the status in the class properties
        $this->data['mod_id'] = intval($modId);
        $this->data['status'] = intval($status);

        // checks for error
        if (
            !$this->isUserAdmin($userModel)
            || $this->validateStatus()
        ) {
            return false;
        }

        // update the status in the db
        if ($this->updateStatusInDb($status)) {
            return true;
        }
        // in case of pdo error
        $this->modApproveError = "something-went-wrong";
        return false;
    }

    /**
     * checks if the user is an admin
     * 
     * @param object $userModel
     * 
     * @return true success status
     */
    private function isUserAdmin($userModel) {
        if ($userModel->isUserAdmin($_SESSION['uid'])) {
            return true;
        }
        $this->modApproveError = "permission-denied";
        return false;
    }

    /**
     * checks if the status is valid
     * 
     * @return bool true on error, false othewise
     */
    private function validateStatus() {
        if (!in_array($this->data['status'], $this->allowedStatuses)) {
            $this->modApproveError = "invalid-status";
            return true;
        }
        
        return false;
    }

    /**
     * updates the mod status in the db
     * 
     * @return bool success status
     */
    private function updateStatusInDb() {
        $sql = "UPDATE mods SET status = ? WHERE id = ?";
        $inParamters = [$this->data['status'], $this->data['mod_id']];

        // tries to run the query
        if ($this->executeStmt($sql, $inParamters)) {
            return true;
        }
        $this->PDOError = true;
        return false;
    }
}