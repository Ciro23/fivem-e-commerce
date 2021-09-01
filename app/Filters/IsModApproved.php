<?php

namespace App\Filters;

use App\Models\Mod\ModModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class IsModApproved implements FilterInterface {

    public function before(RequestInterface $request, $arguments = null) {
        // gets the mod id from the url
        // url will be like this ['mod', '10', ...]
        $uri = &$request->uri;
        $segments = array_filter($uri->getSegments());
        $id = $segments[1];

        $modModel = new ModModel();

        if (!$modModel->isApproved($id)) {
            throw new PageNotFoundException();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
    }
}
