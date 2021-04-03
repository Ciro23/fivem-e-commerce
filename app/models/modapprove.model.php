<?php

class ModApproveModel extends Mvc\Model {

    /**
     * @var string $error
     */
    public $error = "";

    /**
     * @var array $data
     */
    private $data = [
        "mod_id" => "",
        "status" => ""
    ];

    private $allowedStatuses = [0, 1, 2];

    /**
     * updates the mod status
     * 
     * @param int $modId
     * @param int $status (0 => rejected, 1 => pending, 2 => approved)
     * 
     * @return bool success status
     */
    public function updateStatus($modId, $status) {
        // saves the mod id and the status in the class properties
        $this->data['mod_id'] = intval($modId);
        $this->data['status'] = intval($status);

        // update the status in the db
        if ($this->updateStatusInDb($status)) {
            return true;
        }
        // in case of pdo error
        $this->error = "something-went-wrong";
        return false;
    }

    /**
     * updates the mod status in the db
     * 
     * @param int $status (0 => rejected, 1 => pending, 2 => approved)
     * 
     * @return bool success status
     */
    private function updateStatusInDb($status) {
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