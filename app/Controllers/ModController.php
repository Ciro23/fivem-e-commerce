<?php

namespace App\Controllers;

use App\Models\ModModel;

class ModController extends BaseController {
    
    /**
     * shows the mod page
     */
    public function index(int $modId): void {
        $modModel = new ModModel;

        // gets the mod data
        $data = $modModel->getModDetails($modId);

        if ($data) {
            echo view("mod", $data);
        } else {
            echo view("pagenotfound");
        }
    }
}