<?php

namespace App\Libraries;

class ViewCells {

    public function header(array $params): string {
        return view("view_cells/header", $params);
    }

    public function footer(array $params): string {
        return view("view_cells/footer", $params);
    }

    public function modPreview(array $params): string {
        return view("view_cells/mod_preview", $params);
    }
}
