<?php

namespace App\Filters;

use App\Models\User\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class DoesUserExist implements FilterInterface {

    public function before(RequestInterface $request, $arguments = null) {
        // gets the mod id from the url
        // url will be like this ['mod', '10', ...]
        $uri = service("uri");
        $segments = $uri->getSegments();
        $id = $segments[1];

        $userModel = new UserModel();

        if (!$userModel->doesUserExist($id)) {
            throw new PageNotFoundException();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
    }
}
