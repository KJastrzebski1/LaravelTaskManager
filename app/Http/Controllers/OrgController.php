<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OrgRepository;
use App\Organization;
use App\User;
use App\Http\Requests;
use Folklore\Image\Facades\Image;

class OrgController extends Controller {

    protected $organizations;

    public function __construct(OrgRepository $orgs) {
        $this->organizations = $orgs;
    }

    public function index(Request $request) {
        $orgs = Organization::get();
        $args = [
            'organizations' => $orgs,
        ];
        return view('organization.index', $args);
    }

    public function create() {
        return view('organization.create');
    }
    
    public function manage(Request $request, $id){
        $org = Organization::findOrFail($id);
        $this->authorize('manage', $org);
        return view('organization.manage', ['org' => $org]);
    }
    

    public function newOrg(Request $request) {
        $path = 'uploads/';
        $file = $request->file('organization_logo');
        $logo = str_replace(' ', '_', $request->organization_name) .rand(1,100). '_logo.' . $file->getClientOriginalExtension();
        
        if (!Organization::where('name', $request->organization_name)->first()) {
            $org = Organization::create([
                        'name' => $request->organization_name,
                        'logo' => $path . $logo,
                        'ceo_id' => $request->user()->id,
            ]);
            $file->move($path, $logo);
            Image::make($path . $logo, array(
                'width' => 150,
                'height' => 150,
            ))->save($path . $logo);
        }else{
            return view('organization.create', ['error' => 'Organization already exists']);
        }
        return redirect('/organization');
    }

}
