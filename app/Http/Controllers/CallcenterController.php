<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class CallcenterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = self::getCallCenters();
        $args = [ 'users' => $users];
        return view('admin.callcenters.index', $args);
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
        $msg = 'Password Not Changed';
        $id = $request->input('id');
        $newPass = $request->input('password');
        $currUser = Auth::user();
        $upUser = User::find($id);
        if( $currUser->domain() == $upUser->domain() or $currUser->domain() == 'ADMIN' ){
            $msg = 'Password Changed';
            return $msg;
        }
        return $msg;
        
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
