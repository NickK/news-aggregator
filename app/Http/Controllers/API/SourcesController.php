<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Http\Requests;

use \App\Sources as Sources;
use \App\UserSourcesRel as UserSourcesRel;
use \App\Http\Resources\initSources as initSources;
use Auth;


class SourcesController extends Controller
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
        //
        $user = Auth::user();        
        $sources = Sources::all();
        $user_sources = UserSourcesRel::where('userID', '=', $user->id)->get();

        # Add active state
        foreach($sources as $src_item) {
            foreach($user_sources as $userItem) {
                if ($src_item->sourceID == $userItem->sourceID) {
                    $src_item->active = true;
                }
            }
        }
        return initSources::collection($sources);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = Auth::user()->id;
        if (!$request->active) {
            $userSourceRel = UserSourcesRel::where('sourceID', '=', $request->sourceID);
            $userSourceRel->delete();
        } else {
            $userSourceRel = new UserSourcesRel;
            $userSourceRel->userID = $id;
            $userSourceRel->sourceID = $request->sourceID;
            $userSourceRel->save();
        }
    }

}
