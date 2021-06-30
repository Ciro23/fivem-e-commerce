<?php

namespace App\Filters;

use App\Models\User\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class IsUserAdmin implements FilterInterface {

    public function before(RequestInterface $request, $arguments = null) {
        $session = session();
        $userModel = new UserModel();

        if (!$userModel->isUserAdmin($session->uid)) {
            throw new PageNotFoundException();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
    }
}
