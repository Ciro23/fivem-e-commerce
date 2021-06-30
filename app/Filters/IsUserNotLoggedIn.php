<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class IsUserNotLoggedIn implements FilterInterface {

    public function before(RequestInterface $request, $arguments = null) {
        $session = session();
        if ($session->is_logged_in === true) {
            return redirect("home");
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
    }
}
