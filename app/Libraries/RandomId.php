<?php

namespace App\Libraries;

class RandomId {

    public function generateRandomId() {
        $string = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

        return substr(str_shuffle($string), 0, 8);
    }
}
