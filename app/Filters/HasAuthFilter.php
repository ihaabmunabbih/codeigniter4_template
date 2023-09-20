<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class HasAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
    	if (session('logged_in')) {
            return redirect()->to(base_url("home"));
        }
        // Do something here
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}