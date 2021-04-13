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

    /**
     * deletes a folder and all its content
     * 
     * @param string $path
     * 
     * @return bool success status
     */
    public static function deleteFolderAndItsContent($path) {
        //* to do
    }
}