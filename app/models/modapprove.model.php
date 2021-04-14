<?php

class ModApproveModel extends Mvc\Model {

    /**
     * @var string $modApproveError
     */
    private string $modApproveError = "";

    /**
     * @var array $modData
     */
    private array $modData = [
        "id" => "",
        "status" => ""
    ];

    private array $allowedStatuses = [0, 1, 2];

    /**
     * returns the error
     * 
     * @return error
     */
    public function getModApproveError(): string {
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
    public function updateModStatus(int $modId, int $status, UserModel $userModel): bool {
        // saves the mod id and the status in the class properties
        $this->modData['id'] = intval($modId);
        $this->modData['status'] = intval($status);

        // checks for error
        if (
            !$this->isUserAdmin($userModel)
            || $this->validateModStatus()
        ) {
            return false;
        }

        // update the status in the db
        if ($this->updateModStatusInDb($status)) {
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
    private function isUserAdmin(UserModel $userModel): bool {
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
    private function validateModStatus(): bool {
        if (!in_array($this->modData['status'], $this->allowedStatuses)) {
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
    private function updateModStatusInDb(): bool {
        $sql = "UPDATE mods SET status = ? WHERE id = ?";
        $inParamters = [$this->modData['status'], $this->modData['id']];

        // tries to run the query
        if ($this->executeStmt($sql, $inParamters)) {
            return true;
        }
        
        return false;
    }
}