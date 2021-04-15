<?php

class ModApproveModel extends Mvc\Model {

    private string $modApproveError = "";

    private array $modData = [
        "id" => "",
        "status" => ""
    ];

    private array $allowedStatuses = [0, 1, 2];

    public function getModApproveError(): string {
        return $this->modApproveError;
    }

    public function updateModStatus(int $modId, int $status, UserModel $userModel): bool {
        // saves the mod id and the status in the class properties
        $this->modData['id'] = intval($modId);
        $this->modData['status'] = intval($status);

        // checks for error
        if (
            !$this->isUserAdmin($userModel)
            || !$this->isModStatusValid()
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

    private function isUserAdmin(UserModel $userModel): bool {
        if ($userModel->isUserAdmin($_SESSION['uid'])) {
            return true;
        }
        $this->modApproveError = "permission-denied";
        return false;
    }

    private function isModStatusValid(): bool {
        if (!in_array($this->modData['status'], $this->allowedStatuses)) {
            $this->modApproveError = "invalid-status";
            return false;
        }
        
        return true;
    }

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