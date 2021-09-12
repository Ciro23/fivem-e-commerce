<?php

namespace App\Filters;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class IsUserLoggedIn implements FilterInterface {

    public function before(RequestInterface $request, $arguments = null) {
        $session = session();
        
        if ($session->is_logged_in !== true) {
            throw new PageNotFoundException();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
    }
}
