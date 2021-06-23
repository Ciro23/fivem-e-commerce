<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class IsLoggedIn implements FilterInterface {
    
    public function before(RequestInterface $request, $arguments = null) {
        $session = session();
        if ($session->is_logged_in !== true) {
            return redirect()->to("/login");
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}