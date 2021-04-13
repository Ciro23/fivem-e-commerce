<?php

class FileHelper {

    /**
     * gets the file extension
     * 
     * @param string $fileName
     * 
     * @return string extension
     */
    public static function getFileExtension($fileName) {
        return pathinfo($fileName)['extension'];
    }
}