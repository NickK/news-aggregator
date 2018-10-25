<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Requests;

use \App\User as User;
use \App\UserSourcesRel as UserSourcesRel;
use \App\UserTagsRel as UserTagsRel;

use Auth;

class AccountController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
	public function destroy(Request $request) 
	{
		$user = Auth::user();
		$userSourcesRel = UserSourcesRel::where('userID', '=', $user->id);
		$userSourcesRel->delete();

		$userTagsRel = UserTagsRel::where('userID', '=', $user->id);
		$userTagsRel->delete();

		$user = User::where('id', '=', $user->id);
		$user->delete();

		Auth::logout();
		return redirect('/login');
	}
}
