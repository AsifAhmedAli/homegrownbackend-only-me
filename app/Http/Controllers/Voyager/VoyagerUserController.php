<?php

namespace App\Http\Controllers\Voyager;

use App\Mail\AssignGrowMasterToCustomer;
use App\Models\Chat;
use App\Models\Message;
use App\User;
use App\Utils\Helpers\Helper;
use Auth;
use Illuminate\Http\Request;
use Voyager;

class VoyagerUserController extends VoyagerController
{
    public function profile(Request $request)
    {
        $route = '';
        $dataType = Voyager::model('DataType')->where('model_name', Auth::guard(app('VoyagerGuard'))->getProvider()->getModel())->first();
        if (!$dataType && app('VoyagerGuard') == 'web') {
            $route = route('voyager.users.edit', Auth::user()->getKey());
        } elseif ($dataType) {
            $route = route('voyager.' . $dataType->slug . '.edit', Auth::user()->getKey());
        }

        return Voyager::view('voyager::profile', compact('route'));
    }

    // POST BR(E)AD
    public function update(Request $request, $id)
    {
        if (Auth::user()->getKey() == $id) {
            $request->merge([
                'role_id' => Auth::user()->role_id,
                'user_belongstomany_role_relationship' => Auth::user()->roles->pluck('id')->toArray(),
            ]);
        }

        return parent::update($request, $id);
    }

    public function searchGrowOperator()
    {
        $results = User::select('id')->selectRaw('concat(first_name, " ", last_name) as text')->whereRaw('concat(first_name, " ", last_name) like ?', ['%' . request('search', '') . '%'])->growMaster()->active()->get()->toArray();

        $results = Helper::addNoneOptionToDropDown($results);

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => false,
            ],
        ]);
    }

    public function assign(User $user)
    {
        abort_if($user->subscriptions()->count() === 0, 404);
        abort_if(!Helper::isAdmin(), 403);
        $data['user'] = $user;
        $data['title'] = 'Grow Master Assigned';
        $data['dataType'] = Voyager::model('DataType')->where('slug', '=', 'users')->first();

        return view('voyager::users.assign')->with($data);
    }

    public function postAssign(User $user, Request $request)
    {
        abort_if($user->subscriptions()->count() === 0, 404);
        abort_if(!Helper::isAdmin(), 403);
        $user->assigned_to = $request->assigned_to != '0' ? $request->assigned_to : NULL;
        $user->save();
        if ($request->get('assigned_to') && $request->get('assigned_to') != '0') {
            $message = 'GrowMaster assigned successfully.';
            $this->sendAssignGrowMasterEmailToUser($user);
            $this->assignChatToGrowMaster($user, $request->assigned_to);
        } else {
            $message = 'GrowMaster is unassigned.';
        }

        return redirect('/admin/customers')->with(['message' => $message]);
    }

    private function assignChatToGrowMaster($user, $growMasterID)
    {
        Chat::whereChatWith($user->id)->update([
            'assigned_to' => $growMasterID
        ]);
        Message::whereSender($user->id)->update([
            'receiver' => $growMasterID
        ]);
    }

    private function sendAssignGrowMasterEmailToUser($user)
    {
        $growmaster = User::find($user->assigned_to);
        $growmasterFullName = '';
        if (!empty($growmaster->first_name) && (!empty($growmaster->last_name))) {
            $growmasterFullName = ucwords($growmaster->first_name . ' ' . $growmaster->last_name);
        }
        \Mail::to($user->email)->send(new AssignGrowMasterToCustomer($growmasterFullName, $user));
    }
}
