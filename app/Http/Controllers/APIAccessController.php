<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\User;

class APIAccessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function callcenters(Request $request){
        $args = [ 'users' => self::getCallCenters()];
        return $args;
    }

    public function getCallCenters(){
        $user = Auth::user();
        $domain = $user->domain();
        if($domain == 'ADMIN'){
            $users = User::all();
        }else{
            $users = User::where('username', 'like', '%'.$domain)->get();
        }
        return $users;
    }

    public function setPassword(Request $request){
        $msg['status'] = 'Password Not Changed';
        $msg['alert'] = 'danger';
        $id = $request->input('id');
        $newPass = $request->input('password');
        $currUser = Auth::user();
        $upUser = User::find($id);
        if( $currUser->domain() == $upUser->domain() or $currUser->domain() == 'ADMIN' ){
            $upUser->password = Hash::make($newPass);
            $upUser->save();
            $msg['status'] = 'Password was successfully changed for ' . $upUser->username . '';
            $msg['alert'] = 'success';
        }
        return $msg;
    }
    
    public function userDelete(Request $request){
        $msg['status'] = 'There is an error, the specified username was not deleted!';
        $msg['alert'] = 'danger';
        $id = $request->input('id');
        $currUser = Auth::user();
        $delUser = User::find($id);
        $username = $delUser->username;
        if( ($currUser->domain() == $delUser->domain() or $currUser->domain() == 'ADMIN') and $currUser->username != $delUser->username){
            $delUser->delete();
            $msg['status'] = 'Username ' . $username . ' was deleted successfully!';
            $msg['alert'] = 'success';
        }
        return $msg;
    }
    public function addUser(Request $r){
        $msg['status'] = 'User cannot be created at the moment, please try again later!';
        $msg['alert'] = 'danger';
        $currUser = Auth::user();
        $username = null;
        if($currUser->domain() == 'ADMIN'){
            // check if domain is included, if not, use current as Default
            $u = explode('@', $r->input('username'));
            if( count($u) == 2 ){
                $username = $r->input('username');
            }
            else{
                $username = $u[0] . '@ADMIN';
            }
        }
        else {
            $u = explode('@', $r->input('username'));
                $username = $u[0]. '@' . $currUser->domain();
        }
        if(isset($username)){
            $user = new User();
            $user->name = $r->input('name');
            $user->username = $username;
            $user->password = Hash::make($r->input('password'));
            $user->email = $r->input('email');
            $saved = $user->save();
            if(!$saved){
                return $msg;
            }
            $msg['status'] = 'User has been created!';
            $msg['alert'] = 'success';
            $msg['user'] = $user;
        }
        return $msg;
    }
}
