<?php

namespace App\Filters;

use App\Models\User\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class IsAdmin implements FilterInterface {
    
    public function before(RequestInterface $request, $arguments = null) {
        $session = session();
        $userModel = new UserModel();

        if (!$userModel->isUserAdmin($session->uid ?? 0)) {
            return redirect()->to("/");
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}