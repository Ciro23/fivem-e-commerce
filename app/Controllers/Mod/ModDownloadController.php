<?php

namespace App\Controllers\Mod;

use App\Controllers\BaseController;
use App\Models\Mod\ModModel;

class ModDownloadController extends BaseController {

    /**
     * downloads the specified mod file
     */
    public function download(int $modId) {
        $modModel = new ModModel();
        $mod = $modModel->getModDetails($modId);

        $download = $this->response->download(WRITEPATH . "uploads/mods_files/" . $modId . "/file." . $mod->file_ext, null);
        $download->setFileName($mod->name . "." . $mod->file_ext);

        return $download;

        // close the browser window of the download
        echo "<script>window.close();</script>";
    }
}
