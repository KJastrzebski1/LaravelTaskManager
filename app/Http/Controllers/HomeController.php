<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use App\Repositories\OrgRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $organizations;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OrgRepository $orgs)
    {
        
        $this->organizations = $orgs;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if(!$request->user()){
            return view('static.home');
        }
        $orgs = $this->organizations->forUser($request->user());
        return view('static.welcome', ['organizations' => $orgs]);
    }
}
