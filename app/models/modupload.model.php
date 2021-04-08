<?php

class ModUploadModel extends Mvc\Model {

    /**
     * @var string $error
     */
    private $error = "";

    /**
     * @var array $data contains all form data
     */
    private $data = [
        "name" => "",
        "description" => "",
        "version" => "",
        "author" => "",
        "file" => "",
        "image" => ""
    ];

    /**
     * @var array $allowedExt
     */
    private $allowedExt = [
        "file" => [
            'zip',
            'rar'
        ],
        "image" => [
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
    public function getError() {
        return $this->error;
    }

    /**
     * returns the mod name
     * 
     * @return string
     */
    public function getName() {
        return $this->data['name'];
    }

    /**
     * returns the mod description
     * 
     * @return string
     */
    public function getDescription() {
        return $this->data['description'];
    }

    /**
     * returns the mod version
     * 
     * @return string
     */
    public function getVersion() {
        return $this->data['version'];
    }

    /**
     * performs the upload action
     * 
     * @param array $inputData
     * @param object $modModel
     * 
     * @return bool success status
     */
    public function upload($inputData, $modModel) {
        // gets the form input
        $this->data = InputHelper::getFormInput($this->data, $inputData[0]);
        $this->data = InputHelper::getFormInput($this->data, $inputData[1]);

        $this->data['author'] = $_SESSION['uid'];

        // saves the extension of the file and the image
        $this->data['file']['ext'] = $this->getExtension($this->data['file']['name']);
        $this->data['image']['ext'] = $this->getExtension($this->data['image']['name']);

        // checks for errors
        if (
            $this->validateName($modModel)
            || $this->validateDescription()
            || $this->validateVersion()
            || $this->validateFile()
            || $this->validateImage()
        ) {
            return false;
        }

        // the file new name is the mod name + the file extension
        $newFileName = $this->data['name'] . "." . $this->data['file']['ext'];

        // the image new name is the mod name + the image extension
        $newImageName = $this->data['name'] . "." . $this->data['image']['ext'];

        // new paths for the file and the image
        $newFilePath = $_ENV['modsFolder'] . $newFileName;
        $newImagePath = $_ENV['imgsFolder'] . $newImageName;

        // tries to insert the data into the db and to store the uploaded files
        if (
            $this->insertIntoDb()
            && move_uploaded_file($this->data['file']['tmp_name'], $newFilePath)
            && move_uploaded_file($this->data['image']['tmp_name'], $newImagePath)
        ) {
            return true;
        }
        // in case of pdo error
        $this->error = "something-went-wrong";
        return false;
    }

    /**
     * checks if the name is valid
     * 
     * @return bool true on error, false otherwise
     */
    private function validateName($modModel) {
        if (empty($this->data['name'])) {
            $this->error = "name-cant-be-empty";
            return true;
        }

        if ($modModel->doesNameExists($this->data['name'])) {
            $this->error = "name-is-already-taken";
            return true;
        }

        if (!preg_match("/^[A-Za-z0-9\s]+$/", $this->data['name'])) {
            $this->error = "name-can-only-contains-alphanumeric-characters-and-spaces";
            return true;
        }

        if (strlen($this->data['name']) < 4 || strlen($this->data['name']) > 30) {
            $this->error = "name-length-must-be-between-4-and-30";
            return true;
        }

        return false;
    }

    /**
     * checks if the description is valid
     * 
     * @return bool true on error, false otherwise
     */
    private function validateDescription() {
        if (empty($this->data['description'])) {
            $this->error = "description-cant-be-empty";
            return true;
        }

        if (strlen($this->data['description']) < 10 || strlen($this->data['description']) > 200) {
            $this->error = "description-length-must-be-between-10-and-200";
            return true;
        }

        return false;
    }

    /**
     * checks if the version is valid
     * 
     * @return bool true on error, false otherwise
     */
    private function validateVersion() {
        if (empty($this->data['version'])) {
            $this->error = "version-cant-be-empty";
            return true;
        }

        if (!preg_match("/\d+(?:\.\d+){1,2}/", $this->data['version'])) {
            $this->error = "invalid-version-format";
            return true;
        }
    }

    /**
     * checks if the file is valid
     * 
     * @return bool true on error, false otherwise
     */
    private function validateFile() {
        if (empty($this->data['file'])) {
            $this->error = "file-cant-be-empty";
            return true;
        }

        if (!in_array($this->data['file']['ext'], $this->allowedExt['file'])) {
            $this->error = "file-must-be-zip-or-rar";
            return true;
        }

        if ($this->data['file']['size'] > 50000000) {
            $this->error = "file-maximum-size-is-50-mb";
            return true;
        }
    }

    /**
     * checks if the image is valid
     * 
     * @return bool true on error, false otherwise
     */
    private function validateImage() {
        if (empty($this->data['image'])) {
            $this->error = "image-cant-be-empty";
            return true;
        }

        if (!in_array($this->data['image']['ext'], $this->allowedExt['image'])) {
            $this->error = "image-must-be-jpg-or-png";
            return true;
        }

        if ($this->data['image']['size'] > 2000000) {
            $this->error = "image-maximum-size-is-2-mb";
            return true;
        }
    }

    /**
     * gets the file extension
     * 
     * @param string $fileName
     * 
     * @return string extension
     */
    private function getExtension($fileName) {
        return pathinfo($fileName)['extension'];
    }

    /**
     * insert the data into the db
     * 
     * @return bool success status
     */
    private function insertIntoDb() {
        $sql = "INSERT INTO mods (name, description, version, size, author, file_ext, image_ext) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $inParameters = [
            $this->data['name'],
            $this->data['description'],
            $this->data['version'],
            $this->data['file']['size'],
            $this->data['author'],
            $this->data['file']['ext'],
            $this->data['image']['ext']
        ];

        // tries to run the query
        if ($this->executeStmt($sql, $inParameters)) {
            return true;
        }
        $this->PDOError = true;
        return false;
    }
}
