<?php

namespace App\Filters;

use App\Models\Mod\ModModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class IsModApproved implements FilterInterface {

    public function before(RequestInterface $request, $arguments = null) {
        // $segments will be something like ['download', 'mod', '10']
        $uri = &$request->uri;
        $segments = array_filter($uri->getSegments());

        $id = $segments[2];

        $modModel = new ModModel();

        if (!$modModel->isApproved($id)) {
            throw new PageNotFoundException();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
    }
}
