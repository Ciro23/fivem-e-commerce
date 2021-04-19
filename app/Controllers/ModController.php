<?php

namespace App\Controllers;

class ModController extends BaseController {
    
    /**
     * shows the mod page
     */
    public function index(int $modId): void {
        $modModel = $this->model("Mod");

        // gets the mod data
        $data = $modModel->getModDetails($modId);

        if ($data) {
            $this->view("mod", $data);
        } else {
            $this->view("pagenotfound");
        }
    }
}