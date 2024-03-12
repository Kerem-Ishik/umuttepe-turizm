<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthCheckFilter implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->has('loggedUser')) {
            return redirect()->to(base_url('login'))->with('fail', 'Giriş yapmanız gerekiyor.');
        }

        return true;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // TODO: Implement after() method.
    }
}