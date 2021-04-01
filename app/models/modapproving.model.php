<?php

class ModApprovingModel extends Mvc\Model {

    /**
     * @var string $error
     */
    public $error = "";

    /**
     * @var int $modId
     */
    private $modId;

    /**
     * updates the mod status
     * 
     * @param int $modId
     * @param int $status (0 => rejected, 1 => pending, 2 => approved)
     * 
     * @return bool success status
     */
    public function updateStatus($modId, $status) {
        // saves the mod id in the class properties
        $this->modId = $modId;

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
        $sql = "UPDATE mod SET status = ? WHERE id = ?";
        $inParamters = [$status, $this->modId];

        // tries to run the query
        if ($this->executeStmt($sql, $inParamters)) {
            return true;
        }
        $this->PDOError = true;
        return false;
    }
}