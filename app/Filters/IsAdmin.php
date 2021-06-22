<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class IsAdmin implements FilterInterface {
    
    public function before(RequestInterface $request, $arguments = null) {
        $session = session();
        $userModel = new UserModel();

        if (!$userModel->isAdmin($session->id)) {
            return redirect()->to("/");
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}