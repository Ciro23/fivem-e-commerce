<?php

class ModModel extends Mvc\Model {

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
}