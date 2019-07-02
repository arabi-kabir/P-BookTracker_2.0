<?php

namespace App\Http\Controllers\User;

use App\FriendRelation;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function users(){
        return view('MyView.User.Friends.BrowseUser.userlist');
    }

    public function getUserlist(){

        // My Pending Request and Friend list
        $pendingFriends = FriendRelation::leftJoin('users', 'users.id', 'friend_relation.fk_friend_user_id')
                                        ->where('fk_user_id', Auth::user()->id)
                                        ->where('request_status', 0)
//                                        ->orWhere('request_status', 1)
                                        ->get();

        $pending_id_array = array();

        foreach ($pendingFriends as $friend)
        {
            array_push($pending_id_array, $friend->fk_friend_user_id);
        }

        // Other Send Me Request That is Pending
        $pendingReq = FriendRelation::where('fk_friend_user_id', Auth::user()->id)
                                    ->where('request_status', 0)
                                    ->get();

        foreach ($pendingReq as $friend)
        {
            array_push($pending_id_array, $friend->fk_user_id);
        }

        // My Friends
        $friends = FriendRelation::where('fk_user_id', Auth::user()->id)
                                 ->Where('request_status', 1)
                                 ->get();

        foreach ($friends as $friend)
        {
            array_push($pending_id_array, $friend->fk_friend_user_id);
        }

        $users = User::where('id', '!=', Auth::user()->id)
            ->where('userType', '!=' , 'admin')
            ->whereNotIn('id', $pending_id_array)
            ->get();

        return view('MyView.User.Friends.BrowseUser.userlist_ajax')->with('users', $users);
    }

    public function getPendinglist(){
        $pendingFriends = FriendRelation::leftJoin('users', 'users.id', 'friend_relation.fk_friend_user_id')
            ->where('fk_user_id', Auth::user()->id)
            ->where('request_status', 0)
            ->get();

        return view('MyView.User.Friends.BrowseUser.pendinglist_ajax')->with('pendingFriends',$pendingFriends);
    }

    public function sentRequest(Request $r){
        $friend_relation = new FriendRelation();
        $friend_relation->fk_user_id = Auth::user()->id;
        $friend_relation->fk_friend_user_id = $r->user_id;
        $friend_relation->request_status = 0;
        $friend_relation->created_at = date("Y-m-d H:i:s");
        $friend_relation->save();

        return back();
    }

    // CANCEL REQUEST
    public function cancelRequest(Request $r){
        $friend_relation = FriendRelation::where('fk_user_id', Auth::user()->id)
                                         ->where('fk_friend_user_id', $r->user_id)->first();

        $friend_relation->delete();

        return back();
    }

    // New Request List
    public function newRequestList(){
        return view('MyView.User.Friends.NewFriendRequest.requestList');
    }

    // GET NEW REQUEST AJAX
    public function newRequestListGet(){
        $pendingRequests = FriendRelation::leftJoin('users', 'users.id', 'friend_relation.fk_friend_user_id')
                                    ->where('fk_friend_user_id', Auth::user()->id)
                                    ->where('request_status', 0)
                                    ->get();

        $pending_id_array = array();

        foreach ($pendingRequests as $friend)
        {
            array_push($pending_id_array, $friend->fk_user_id);
        }

        $pendingRequests = User::whereIn('id', $pending_id_array)->get();

        return view('MyView.User.Friends.NewFriendRequest.requestList_ajax')->with('pendingFriends',$pendingRequests);
    }

    // NEW REQUEST ACCEPT
    public function newRequestListAccept(Request $r){
        $user = FriendRelation::where('fk_friend_user_id', Auth::user()->id)
                              ->where('fk_user_id', $r->user_id)
                              ->first();

        $user->request_status = 1;
        $user->save();

        //
        $friend_relation = new FriendRelation();
        $friend_relation->fk_user_id = Auth::user()->id;
        $friend_relation->fk_friend_user_id = $r->user_id;
        $friend_relation->request_status = 1;
        $friend_relation->created_at = date("Y-m-d H:i:s");
        $friend_relation->save();


        return back();
    }

    public function newRequestListReject(Request $r){
        $user = FriendRelation::where('fk_friend_user_id', Auth::user()->id)
            ->where('fk_user_id', $r->user_id)
            ->first();

        $user->delete();

        return back();
    }

    public function friendslist(){
        return view('MyView.User.Friends.MyFriends.friendlist');
    }

    public function friendslistGet(){
        $friends = FriendRelation::leftJoin('users', 'users.id', 'friend_relation.fk_friend_user_id')
                                         ->where('fk_user_id', Auth::user()->id)
                                         ->where('request_status', 1)
                                         ->get();

        return view('MyView.User.Friends.MyFriends.friendslist_ajax')->with('friends', $friends);
    }

    // Un follow friend
    public function unfriend(Request $r){
        $user = FriendRelation::where('fk_user_id', Auth::user()->id)
                              ->where('fk_friend_user_id', $r->user_id)
                              ->where('request_status', 1)
                              ->first();
        $user->delete();

        return back();
    }
}
