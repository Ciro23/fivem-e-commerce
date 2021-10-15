<?php

namespace App\Filters;

use App\Models\User\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class IsUserProfileOwner implements FilterInterface {

    public function before(RequestInterface $request, $arguments = null) {
        // gets the mod id from the url
        // url will be like this ['user', '10', ...]
        $uri = service("uri");
        $segments = $uri->getSegments();
        $id = $segments[1];

        $modModel = new UserModel();

        if ($modModel->getUserDetails($id)->id != session("uid")) {
            throw new PageNotFoundException();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
    }
}
