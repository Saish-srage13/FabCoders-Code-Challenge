<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Shared\Controller;
use Illuminate\Http\Request;

class CBaseController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct();

        $this->request = $request;

        $this->layout->addCSS([
            '/assets/css/custom.css',
            '/assets/css/bootstrap.min.css',
            '/assets/fontawesome/css/all.min.css',       
            '/assets/css/sweetalert2.min.css',       
        ]);
        
        $this->layout->addJS([
            '/assets/js/bootstrap.min.js',
            '/assets/js/fontawesome.min.js',
            '/assets/js/sweetalert2.all.min.js',
        ]);
    }

    public function getFilters($request)
    {
        $where = [];
        if ($request->has('keywords')) {
            $where['keywords'] = $request->get('keywords');
        }

        if ($request->has('status')) {
            $where['status'] = $request->get('status');
        }
                
        return $where;
    }
}