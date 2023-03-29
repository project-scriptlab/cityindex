<?php

namespace App\Controllers;

use Config\Services;

class Dashboard extends BaseController
{

    /**
     * Access to current session.
     *
     * @var \CodeIgniter\Session\Session
     */
    protected $session;

    public function __construct()
    {
        // start session
        $this->session = Services::session();
    }


    public function index()
    {
        if (!$this->session->isLoggedIn) {
            return redirect()->to('login');
        }
        $this->data['title'] = 'dashboard';
        return  view('dashboard/dashboard', $this->data);    
    }
    public function barcode()
    {
        if (!$this->session->isLoggedIn) {
            return redirect()->to('login');
        }
       echo "<img src ='/BCG/html/image.php?filetype=PNG&dpi=72&scale=1&rotation=0&font_family=Arial.ttf&font_size=10&text=1234&thickness=50&start=NULL&code=BCGcode128' />";
    }
}
