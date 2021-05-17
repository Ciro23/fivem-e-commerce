<?php

namespace App\Models\Mod;

use CodeIgniter\Model;

class ModUploadModel extends Model {

    private string $modUploadError = "";

    private array $modData = [
        "name" => "",
        "description" => "",
        "version" => "",
        "author" => "",
        "file" => "",
        "logo" => ""
    ];

    private array $allowedExt = [
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

    public function getModUploadError(): string {
        return $this->modUploadError;
    }

    public function getModName(): string {
        return $this->modData['name'];
    }

    public function getModDescription(): string {
        return $this->modData['description'];
    }

    public function getModVersion(): string {
        return $this->modData['version'];
    }

    public function uploadMod(array $inputData, ModModel $modModel): bool {
        // gets the form input
        $this->modData = \InputHelper::getFormInput($this->modData, $inputData[0]);
        $this->modData = \InputHelper::getFormInput($this->modData, $inputData[1]);

        $this->modData['author'] = $_SESSION['uid'];

        // saves the extension of the file and the logo
        $this->modData['file']['ext'] = \FileHelper::getFileExtension($this->modData['file']['name']);
        $this->modData['logo']['ext'] = \FileHelper::getFileExtension($this->modData['logo']['name']);

        // checks for errors
        if (
            !$this->isModNameValid($modModel)
            || !$this->isModDescriptionValid()
            || !$this->isModVersionValid()
            || !$this->isModFileValid()
            || !$this->isModLogoValid()
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
        //! to rethink, it's completely broken
        //$this->rollBack($modModel);

        // saves the error and returns
        $this->modUploadError = "something-went-wrong";
        return false;
    }

    private function isModNameValid(ModModel $modModel): bool {
        if (empty($this->modData['name'])) {
            $this->modUploadError = "name-cant-be-empty";
            return false;
        }

        if ($modModel->doesModNameExists($this->modData['name'])) {
            $this->modUploadError = "name-is-already-taken";
            return false;
        }

        if (!preg_match("/^[A-Za-z0-9\s]+$/", $this->modData['name'])) {
            $this->modUploadError = "name-can-only-contains-alphanumeric-characters-and-spaces";
            return false;
        }

        if (strlen($this->modData['name']) < 4 || strlen($this->modData['name']) > 30) {
            $this->modUploadError = "name-length-must-be-between-4-and-30";
            return false;
        }

        return true;
    }

    private function isModDescriptionValid(): bool {
        if (empty($this->modData['description'])) {
            $this->modUploadError = "description-cant-be-empty";
            return false;
        }

        if (strlen($this->modData['description']) < 10 || strlen($this->modData['description']) > 200) {
            $this->modUploadError = "description-length-must-be-between-10-and-200";
            return false;
        }

        return true;
    }

    private function isModVersionValid(): bool {
        if (empty($this->modData['version'])) {
            $this->modUploadError = "version-cant-be-empty";
            return false;
        }

        if (!preg_match("/\d+(?:\.\d+){1,2}/", $this->modData['version'])) {
            $this->modUploadError = "invalid-version-format";
            return false;
        }

        return true;
    }

    private function isModFileValid(): bool {
        if (empty($this->modData['file'])) {
            $this->modUploadError = "file-cant-be-empty";
            return false;
        }

        if (!in_array($this->modData['file']['ext'], $this->allowedExt['file'])) {
            $this->modUploadError = "file-must-be-zip-or-rar";
            return false;
        }

        if ($this->modData['file']['size'] > 50000000) {
            $this->modUploadError = "file-maximum-size-is-50-mb";
            return false;
        }

        return true;
    }

    private function isModLogoValid(): bool {
        if (empty($this->modData['logo'])) {
            $this->modUploadError = "logo-cant-be-empty";
            return false;
        }

        if (!in_array($this->modData['logo']['ext'], $this->allowedExt['logo'])) {
            $this->modUploadError = "logo-must-be-jpg-or-png";
            return false;
        }

        if ($this->modData['logo']['size'] > 2000000) {
            $this->modUploadError = "logo-maximum-size-is-2-mb";
            return false;
        }

        return true;
    }

    /**
     * moves the uploaded files to the mods folder
     * creates a new folder named as the new mod id and puts in it the mod file and its logo
     */
    private function moveModFiles(int $modId): bool {
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

    private function insertIntoDb(): bool {
        $sql = "INSERT INTO mods (author, name, description, version, size, file_ext, logo_ext) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = [
            $this->modData['author'],
            $this->modData['name'],
            $this->modData['description'],
            $this->modData['version'],
            $this->modData['file']['size'],
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
     */
    private function rollBack(ModModel $modModel): void {
        // deletes mod row from the db
        $modModel->deleteModFromDb($this->lastInsertId("mods"));

        // deletes mod files from the server
        \FileHelper::deleteFolderAndItsContent($this->modData['id']);
    }
}
