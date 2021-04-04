<?php

class ModController extends Mvc\Controller {
    
    /**
     * shows the mod page
     * 
     * @param int $modId
     */
    public function index($modId) {
        $modModel = $this->model("Mod");

        // gets the mod data
        $data = $modModel->getDetails($modId);

        if ($data !== null) {
            $this->view("mod", $data);
        } else {
            $this->view("pagenotfound");
        }
    }
}