<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\InvitesRepository;
use App\User;
use App\Organization;
use App\Message;
use App\Http\Requests;

class MessageController extends Controller {

    protected $invites;

    public function __construct(InvitesRepository $inv) {
        $this->invites = $inv;
    }

    public function invite(Request $request, $id) {
        $email = $request->member_email;
        $user = User::where('email', $email)->first();
        $org = Organization::findOrFail($id);
        if ($user) {

            $this->authorize('manage', $org);
            if($org->user_ids){
                $users = unserialize($org->user_ids);
            }else{
                $users = [];
            }
            
            if (!in_array($user->id, $users)) {
                Message::create([
                    'user_id' => $user->id,
                    'org_id' => $org->id
                ]);
                return view('organization.manage', [
                    'message' => 'Invitation has been sent',
                    'org' => $org,
                ]);
            }
        } else {
            return view('organization.manage', [
                'message' => 'There is no user with e-mail:' . $email,
                'org' => $org
            ]);
        }
    }

}
