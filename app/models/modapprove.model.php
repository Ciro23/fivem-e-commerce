<?php

class ModApproveModel extends Mvc\Model {

    /**
     * @var string $modApproveError
     */
    private $modApproveError = "";

    /**
     * @var array $modData
     */
    private $modData = [
        "id" => "",
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
    public function updateModStatus($modId, $status, $userModel) {
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

            // if the status is 0, deletes the mod folder
            if (
                $this->modData['status'] == 0
                && !FileHelper::deleteFolderAndItsContent($this->modData['id'])
            ) {
                // in case updateModStatusInDb() or deleteFolderAndItsContent() fail
                // restores previous mod state
                $this->rollBack();

                // saves the error and returns
                $this->modApproveError = "something-went-wrong";
                return false;
            }

            return true;
        }
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
    private function validateModStatus() {
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
    private function updateModStatusInDb() {
        $sql = "UPDATE mods SET status = ? WHERE id = ?";
        $inParamters = [$this->modData['status'], $this->modData['id']];

        // tries to run the query
        if ($this->executeStmt($sql, $inParamters)) {
            return true;
        }
        
        return false;
    }

    /**
     * deletes the mod from the db and delete its files from the server
     * 
     * @param object $modModel
     */
    private function rollBack($modModel) {
        // deletes mod row from the db
        $modModel->deleteModFromDb($this->lastInsertId("mods"));

        // deletes mod files from the server
        FileHelper::deleteFolderAndItsContent($this->modData['id']);
    }
}