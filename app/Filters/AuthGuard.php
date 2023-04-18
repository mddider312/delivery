<?php 
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthGuard implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') == "2")
        {
            if (session()->get('role') == "2") {
                session()->destroy();
                session()->setFlashdata('msg', 'You are not authorized to go to that page.');
            } else {
                session()->setFlashdata('msg', 'Session expired, please login again.');
            }
            
            return redirect()
                ->to('/');
        }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}