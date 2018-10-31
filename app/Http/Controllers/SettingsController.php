<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Requests;
use Auth;
use \App\Sources as Sources;
use \App\UserSourcesRel as UserSourcesRel;
use  \App\User as User;
use \App\Http\Resources\SettingsTags as SettingsTags;

class SettingsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function dashboard() {
    	$user = Auth::user();
    	return view('settings', ['user' => $user]);
    }

    public function updateBasicInfo(Request $request) {
    	$this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

    	$authuser = Auth::user();

  
    	$user = User::find($authuser->id);
		$user->email = $request->email;
		$user->password = bcrypt($request->password);

		$user->save();
		
        return back()->withInput();
    }

}
