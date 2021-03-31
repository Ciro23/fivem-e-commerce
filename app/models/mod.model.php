<?php

class ModModel extends Mvc\Model {

    /**
     * @var string|false $error
     */
    public $error;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $description
     */
    private $description;

    /**
     * @var string $version
     */
    private $version;

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
     * performs the upload action
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
        $this->file = $_FILES['file']['tmp_name'];
        $this->image = $_FILES['image']['tmp_name'];
    }

    /**
     * validate the name
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
}