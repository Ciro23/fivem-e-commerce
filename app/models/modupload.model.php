<?php

class ModUploadModel extends Mvc\Model {

    /**
     * @var string $error
     */
    private $modUploadError = "";

    /**
     * @var array $modData contains all form modData
     */
    private $modData = [
        "name" => "",
        "description" => "",
        "version" => "",
        "author" => "",
        "file" => "",
        "logo" => ""
    ];

    /**
     * @var array $allowedExt
     */
    private $allowedExt = [
        "file" => [
            'zip',
            'rar'
        ],
        "logo" => [
            'jpg',
            'jpeg',
            'png'
        ]
    ];

    /**
     * returns the error
     * 
     * @return string
     */
    public function getModUploadError() {
        return $this->modUploadError;
    }

    /**
     * returns the mod name
     * 
     * @return string
     */
    public function getModName() {
        return $this->modData['name'];
    }

    /**
     * returns the mod description
     * 
     * @return string
     */
    public function getModDescription() {
        return $this->modData['description'];
    }

    /**
     * returns the mod version
     * 
     * @return string
     */
    public function getModVersion() {
        return $this->modData['version'];
    }

    /**
     * performs the upload action
     * 
     * @param array $inputData
     * @param object $modModel
     * 
     * @return bool success status
     */
    public function uploadMod($inputData, $modModel) {
        // gets the form input
        $this->modData = InputHelper::getFormInput($this->modData, $inputData[0]);
        $this->modData = InputHelper::getFormInput($this->modData, $inputData[1]);

        $this->modData['author'] = $_SESSION['uid'];

        // saves the extension of the file and the logo
        $this->modData['file']['ext'] = FileHelper::getFileExtension($this->modData['file']['name']);
        $this->modData['logo']['ext'] = FileHelper::getFileExtension($this->modData['logo']['name']);

        // checks for errors
        if (
            $this->validateModName($modModel)
            || $this->validateModDescription()
            || $this->validateModVersion()
            || $this->validateModFile()
            || $this->validateModLogo()
        ) {
            return false;
        }

        // tries to insert the modData into the db and to store the uploaded files
        if (
            $this->insertIntoDb()
            && $this->moveModFiles($this->lastInsertId("mods"))
        ) {
            return true;
        }
        
        // in case insertIntoDb() or moveModFiles fails
        // restores previous state
        $this->rollBack($modModel);

        // saves the error and returns
        $this->modUploadError = "something-went-wrong";
        return false;
    }

    /**
     * checks if the name is valid
     * 
     * @return bool true on error, false otherwise
     */
    private function validateModName($modModel) {
        if (empty($this->modData['name'])) {
            $this->modUploadError = "name-cant-be-empty";
            return true;
        }

        if ($modModel->doesModNameExists($this->modData['name'])) {
            $this->modUploadError = "name-is-already-taken";
            return true;
        }

        if (!preg_match("/^[A-Za-z0-9\s]+$/", $this->modData['name'])) {
            $this->modUploadError = "name-can-only-contains-alphanumeric-characters-and-spaces";
            return true;
        }

        if (strlen($this->modData['name']) < 4 || strlen($this->modData['name']) > 30) {
            $this->modUploadError = "name-length-must-be-between-4-and-30";
            return true;
        }

        return false;
    }

    /**
     * checks if the description is valid
     * 
     * @return bool true on error, false otherwise
     */
    private function validateModDescription() {
        if (empty($this->modData['description'])) {
            $this->modUploadError = "description-cant-be-empty";
            return true;
        }

        if (strlen($this->modData['description']) < 10 || strlen($this->modData['description']) > 200) {
            $this->modUploadError = "description-length-must-be-between-10-and-200";
            return true;
        }

        return false;
    }

    /**
     * checks if the version is valid
     * 
     * @return bool true on error, false otherwise
     */
    private function validateModVersion() {
        if (empty($this->modData['version'])) {
            $this->modUploadError = "version-cant-be-empty";
            return true;
        }

        if (!preg_match("/\d+(?:\.\d+){1,2}/", $this->modData['version'])) {
            $this->modUploadError = "invalid-version-format";
            return true;
        }
    }

    /**
     * checks if the file is valid
     * 
     * @return bool true on error, false otherwise
     */
    private function validateModFile() {
        if (empty($this->modData['file'])) {
            $this->modUploadError = "file-cant-be-empty";
            return true;
        }

        if (!in_array($this->modData['file']['ext'], $this->allowedExt['file'])) {
            $this->modUploadError = "file-must-be-zip-or-rar";
            return true;
        }

        if ($this->modData['file']['size'] > 50000000) {
            $this->modUploadError = "file-maximum-size-is-50-mb";
            return true;
        }
    }

    /**
     * checks if the logo is valid
     * 
     * @return bool true on error, false otherwise
     */
    private function validateModLogo() {
        if (empty($this->modData['logo'])) {
            $this->modUploadError = "logo-cant-be-empty";
            return true;
        }

        if (!in_array($this->modData['logo']['ext'], $this->allowedExt['logo'])) {
            $this->modUploadError = "logo-must-be-jpg-or-png";
            return true;
        }

        if ($this->modData['logo']['size'] > 2000000) {
            $this->modUploadError = "logo-maximum-size-is-2-mb";
            return true;
        }
    }

    /**
     * moves the uploaded files to the mods folder
     * creates a new folder named as the new mod id and puts in it the mod file and its logo
     * 
     * @param int $modId
     * 
     * @return bool success status
     */
    private function moveModFiles($modId) {
        // creates the new mod folder
        mkdir($_SERVER['DOCUMENT_ROOT'] . $_ENV['mods_folder'] . $modId);

        // the file new name is the mod name + the file extension
        $newFileName = $this->modData['name'] . "." . $this->modData['file']['ext'];

        // the logo new name is logo+ the logo extension
        $newLogoName = "logo." . $this->modData['logo']['ext'];

        // new paths for the file and the logo
        $newFilePath = $_SERVER['DOCUMENT_ROOT'] . $_ENV['mods_folder'] . $modId . "/" . $newFileName;
        $newLogoPath = $_SERVER['DOCUMENT_ROOT'] . $_ENV['mods_folder'] . $modId . "/" . $newLogoName;

        // tries to move the uploaded files
        if (
            move_uploaded_file($this->modData['file']['tmp_name'], $newFilePath)
            && move_uploaded_file($this->modData['logo']['tmp_name'], $newLogoPath)
        ) {
            return true;
        }
        return false;
    }

    /**
     * insert the modData into the db
     * 
     * @return bool success status
     */
    private function insertIntoDb() {
        $sql = "INSERT INTO mods (name, description, version, size, author, file_ext, logo_ext) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = [
            $this->modData['name'],
            $this->modData['description'],
            $this->modData['version'],
            $this->modData['file']['size'],
            $this->modData['author'],
            $this->modData['file']['ext'],
            $this->modData['logo']['ext']
        ];

        // tries to run the query
        if ($this->executeStmt($sql, $params)) {
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
