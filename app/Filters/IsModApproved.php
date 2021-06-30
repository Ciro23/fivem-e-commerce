<?php

namespace App\Filters;

use App\Models\Mod\ModModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class IsModApproved implements FilterInterface {

    public function before(RequestInterface $request, $arguments = null) {
        // $segments will be something like ['download', 'mod', '10']
        $uri = &$request->uri;
        $segments = array_filter($uri->getSegments());

        for ($i = 0; $i < count($segments); $i++) {
            if ($segments[$i] == "mod") {
                $id = $segments[$i + 1];
            }
        }

        $modModel = new ModModel();

        if (!$modModel->isApproved($id)) {
            throw new PageNotFoundException();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
    }
}
