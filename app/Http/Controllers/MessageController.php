<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MessageRepository;
use App\User;
use App\Organization;
use App\Message;
use App\Repositories\OrgRepository;
use App\Http\Requests;

class MessageController extends Controller {

    protected $msgs, $orgs;

    public function __construct(MessageRepository $inv, OrgRepository $orgs) {
        $this->msgs = $inv;
        $this->orgs = $orgs;
    }

    public function remove(Request $request, $id) {
        $msg = Message::findOrFail($id);
        $msg->delete();
        return redirect('/organization');
    }

    public function accept(Request $request, $id) {
        $msg = Message::findOrFail($id);
        $org = Organization::findOrFail($msg->org_id);
        if ($org->user_ids) {
            $ids = unserialize($org->user_ids);
        } else {
            $ids = [];
        }
        array_push($ids, $request->user()->id);
        $org->user_ids = serialize($ids);
        $org->save();
        $msg->delete();
        return redirect('/organization');
    }

    public function invite(Request $request, $id) {
        $email = $request->member_email;
        $user = User::where('email', $email)->first();
        $org = Organization::findOrFail($id);
        $args = [
            'members' => $this->orgs->getMembers($org),
            'org' => $org,
        ];
        if ($user) {

            $this->authorize('manage', $org);
            if ($org->user_ids) {
                $users = unserialize($org->user_ids);
            } else {
                $users = [];
            }

            if (!in_array($user->id, $users) && !$this->msgs->isInvited($user, $org)) {
                Message::create([
                    'user_id' => $user->id,
                    'org_id' => $org->id
                ]);

                $args['message'] = 'Invitation has been sent';
            }else{
                $args['message'] = 'User is already in organization or has been invited before';
            }
        } else {
             $args['message'] = 'There is no user with e-mail:' . $email;
        }

        return view('organization.manage', $args);
    }

}
