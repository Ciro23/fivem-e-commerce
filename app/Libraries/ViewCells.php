<?php

namespace App\Libraries;

class ViewCells {

    public function modPreview(array $params): string {
        return view("templates/mod_preview", $params);
    }
}
