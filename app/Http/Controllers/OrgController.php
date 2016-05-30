<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OrgRepository;
use App\Organization;
use App\Http\Requests;

class OrgController extends Controller
{
    protected $organizations;

    public function __construct(OrgRepository $orgs) {
        $this->organizations = $orgs;
    }


    public function index(Request $request){
        
        $args = [
            'organizations' => [],
        ];
        return view('organization.index', $args);
    }
    
    public function create(){
        return view('organization.create');
    }
    
    public function newOrg(Request $request){
        $path = '../uploads/';
        $file = $request->file('organization_logo');
        $logo = $request->organization_name.'_logo.'.$file->getClientOriginalExtension();
        $file->move($path, $logo);
        $org = Organization::create([
            'name' => $request->organization_name,
            'logo' => $path.$logo,
        ]);
        return view('organization.indexs');
    }
}
