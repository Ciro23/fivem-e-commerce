<?php

class ModUploadModel extends Mvc\Model {

    /**
     * @var string $error
     */
    public $error = "";

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $description
     */
    public $description;

    /**
     * @var string $version
     */
    public $version;

    /**
     * @var int $author
     */
    private $author;

    /**
     * @var array $file
     */
    private $file;

    /**
     * @var array $image
     */
    private $image;

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
     * performs the upload action
     * 
     * @return bool success status
     */
    public function upload() {
        // gets user input
        extract($_POST);

        // sanitizes user input
        $name = htmlspecialchars($name);
        $description = htmlspecialchars($description);
        $version = htmlspecialchars($version);

        // saves data into class properties
        $this->name = $name;
        $this->description = $description;
        $this->version = $version;
        $this->author = $_SESSION['uid'];
        $this->file = $_FILES['file'];
        $this->image = $_FILES['image'];

        // checks for errors
        if (
            $this->validateName()
            || $this->validateDescription()
            || $this->validateVersion()
            || $this->validateFile()
            || $this->validateImage()
        ) {
            return false;
        }

        // new file name and path
        $newFileName = $this->name . "-" . $this->lastInsertId();
        $newFilePath = $_ENV['modsFolder'] . $newFileName;

        // new image path
        $newImagePath = $_ENV['imgsFolder'] . $newFileName;

        // tries to insert the data into the db and to store the uploaded files
        if (
            $this->insertIntoDb()
            && move_uploaded_file($this->file['tmp_name'], $newFilePath)
            && move_uploaded_file($this->image['tmp_name'], $newImagePath)
        ) {
            return true;
        }
        // in case of pdo error
        $this->error = "something-went-wrong";
        return false;
    }

    /**
     * validates the name
     * 
     * @return bool true on error, false otherwise
     */
    private function validateName() {
        if (empty($this->name)) {
            $this->error = "name-cant-be-empty";
            return true;
        }

        if (!preg_match("/^[A-Za-z0-9]+$/", $this->name)) {
            $this->error = "name-can-only-contains-alphanumeric-characters";
            return true;
        }

        if (strlen($this->name) < 4 || strlen($this->name) > 20) {
            $this->error = "name-length-must-be-between-4-and-20";
            return true;
        }

        return false;
    }

    /**
     * validates the description
     * 
     * @return bool true on error, false otherwise
     */
    private function validateDescription() {
        if (empty($this->description)) {
            $this->error = "description-cant-be-empty";
            return true;
        }

        if (strlen($this->description) < 10 || strlen($this->description) > 200) {
            $this->error = "description-length-must-be-between-10-and-200";
            return true;
        }

        return false;
    }

    /**
     * validates the version
     * 
     * @return bool true on error, false otherwise
     */
    private function validateVersion() {
        if (empty($this->version)) {
            $this->error = "version-cant-be-empty";
            return true;
        }

        if (!preg_match("/\d+(?:\.\d+){1,2}/", $this->version)) {
            $this->error = "invalid-version-format";
            return true;
        }
    }

    /**
     * validates the file
     * 
     * @return bool true on error, false otherwise
     */
    private function validateFile() {
        if (empty($this->file)) {
            $this->error = "file-cant-be-empty";
            return true;
        }

        $extension = $this->getExtension($this->file['name']);

        if (!in_array($extension, $this->allowedExt['file'])) {
            $this->error = "file-must-be-zip-or-rar";
            return true;
        }

        if ($this->file['size'] > 50000000) {
            $this->error = "file-maximum-size-is-50-mb";
            return true;
        }
    }

    /**
     * validates the image
     * 
     * @return bool true on error, false otherwise
     */
    private function validateImage() {
        if (empty($this->image)) {
            $this->error = "image-cant-be-empty";
            return true;
        }

        $extension = $this->getExtension($this->image['name']);

        if (!in_array($extension, $this->allowedExt['image'])) {
            $this->error = "image-must-be-jpg-or-png";
            return true;
        }

        if ($this->image['size'] > 2000000) {
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
        $sql = "INSERT INTO mods (name, description, version, size, author) VALUES (?, ?, ?, ?, ?)";
        $inParameters = [
            $this->name,
            $this->description,
            $this->version,
            $this->file['size'],
            $this->author
        ];

        // tries to run the query
        if ($this->executeStmt($sql, $inParameters)) {
            return true;
        }
        $this->PDOError = true;
        return false;
    }
}
