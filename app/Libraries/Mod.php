<?php

namespace App\Libraries;

class Mod {

    public function modPreview(array $params): string {
        return view("templates/mod_preview", $params);
    }
}
