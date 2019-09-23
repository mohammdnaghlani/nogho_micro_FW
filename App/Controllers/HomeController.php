<?php
namespace App\Controllers ;

use App\Core\Request;
use App\Services\View\View;

class HomeController
{
    public function index(Request $request)
    {
        $data = [
            'users' => [
                'mohammad',
                'mohammad',
                'mohammad',
                'mohammad',
                'mohammad',
                'mohammad',
                'mohammad',
                'mohammad',
                'mohammad',
                'mohammad',
            ],
        ];
        View::load_admin('content.index' , $data , 'admin_layout');

    }
}