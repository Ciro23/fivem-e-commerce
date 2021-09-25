<?php

namespace App\Libraries;

class ViewCells {

    public function header(array $params): string {
        return view("templates/header", $params);
    }

    public function footer(array $params): string {
        return view("templates/footer", $params);
    }

    public function modPreview(array $params): string {
        return view("templates/mod_preview", $params);
    }
}
