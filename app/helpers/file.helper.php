<?php

class FileHelper {

    /**
     * gets the file extension
     * 
     * @param string $fileName
     * 
     * @return string extension
     */
    public static function getExtension($fileName) {
        return pathinfo($fileName)['extension'];
    }
}