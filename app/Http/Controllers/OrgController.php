<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OrgRepository;
use App\Repositories\RoleRepository;
use App\Organization;
use App\User;
use App\Role;
use DB;
use App\Message;
use App\Http\Requests;
use Folklore\Image\Facades\Image;

class OrgController extends Controller {

    protected $organizations, $roles;

    public function __construct(OrgRepository $orgs, RoleRepository $roles) {
        $this->organizations = $orgs;
        $this->roles = $roles;
    }

    public function index(Request $request) {
        $orgs = $this->organizations->forUser($request->user());

        $messages = Message::get();
        $nmessages = [];
        foreach ($messages as $message) {
            if ($message->user_id === $request->user()->id) {
                $message['org_name'] = Organization::findOrFail($message['org_id'])->name;
                $nmessages[] = $message;
            }
        }
        $args = [
            'organizations' => $orgs,
            'messages' => $nmessages,
        ];
        return view('organization.index', $args);
    }

    public function create() {
        return view('organization.create');
    }

    public function manage(Request $request, $id) {
        $org = Organization::findOrFail($id);
        $this->authorize('manage', $org);
        $members = $this->organizations->getMembers($org);
        foreach ($members as $user) {
            $role = $this->roles->getRole($user, $org);
            if ($role) {
                $user->role = $role->name;
            } else {
                $user->role = 'Not assigned';
            }
        }
        return view('organization.manage', [
            'org' => $org,
            'members' => $members,
        ]);
    }

    public function newOrg(Request $request) {
        $path = 'uploads/';
        $file = $request->file('organization_logo');
        $logo = str_replace(' ', '_', $request->organization_name) . rand(1, 100) . '_logo.' . $file->getClientOriginalExtension();

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
            $capabilities = [
                'task_manager',
                'project_manager',
                'organization_manager',
            ];
            $role = Role::create([
                        'name' => 'CEO',
                        'org_id' => $org->id,
                        'capabilities' => serialize($capabilities),
            ]);
            DB::table('user_roles')->insert([
                'user_id' => $request->user()->id,
                'org_id' => $org->id,
                'role_id' => $role->id,
            ]);
        } else {
            return view('organization.create', ['error' => 'Organization already exists']);
        }
        return redirect('/organization');
    }

    public function leave(Request $request, $id) {
        $org = Organization::findOrFail($id);
        $user = $request->user();

        $ids = unserialize($org->user_ids);
        $index = array_search($user->id, $ids);
        array_splice($ids, $index);
        DB::table('user_roles')->where('user_id', $user->id)->where('org_id', $org->id)->delete();
        $org->user_ids = serialize($ids);
        $org->save();
        return redirect('/organization');
    }
    public function getRoles(Request $request){
        $data = $request['data'];
        $org = Organization::findOrFail($data);
        $roles = $this->roles->getRoles($org);
        return response()->json($roles);
    }
}
