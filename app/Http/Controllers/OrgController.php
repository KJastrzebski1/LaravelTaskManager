<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OrgRepository;
use App\Organization;
use App\Http\Requests;
use Folklore\Image\Facades\Image;

class OrgController extends Controller
{
    protected $organizations;

    public function __construct(OrgRepository $orgs) {
        $this->organizations = $orgs;
    }


    public function index(Request $request){
        $orgs = Organization::get();
        $args = [
            'organizations' => $orgs,
        ];
        return view('organization.index', $args);
    }
    
    public function create(){
        return view('organization.create');
    }
    
    public function newOrg(Request $request){
        $path = 'uploads/';
        $file = $request->file('organization_logo');
        $logo = str_replace(' ', '_', $request->organization_name).'_logo.'.$file->getClientOriginalExtension();
        $file->move($path, $logo);
        Image::make($path.$logo, array(
            'width' => 150,
            'height' => 150,
        ))->save($path.$logo);
        $org = Organization::create([
            'name' => $request->organization_name,
            'logo' => $path.$logo,
        ]);
        return redirect('/organization');
    }
}
