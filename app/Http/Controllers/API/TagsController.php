<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use \App\Http\Requests;

use \App\Tags as Tags;
use \App\UserTagsRel as UserTagsRel;
use \App\Http\Resources\initTags as initTags;
use \App\Http\Resources\responseTags as responseTags;

use Auth;


class TagsController extends Controller
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
        $id = Auth::user()->id;
        $user_tags = UserTagsRel::all()->load('tag')->where('userID', $id);
        return initTags::collection($user_tags);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
         $id = Auth::user()->id;

        // Check to make sure request wasn't empty
        if (!empty($request->tagName)) {
            $tag = Tags::checkTags($request->tagName)->first();

            if (empty($tag)) {
                // If Tag needs to be added to the Database
                
                $tags = new Tags;
                $tags->tagName = $request->tagName;
                $tags->save();

                $tagID = $tags->tagID;

            } else {
                // If Tag is already saved in the Database
                $tagID = $tag->tagID;

            }
         
            // Add tagID and user to table
            $rel = new UserTagsRel;
            $rel->tagID = $tagID;
            $rel->userID = $id;

            if ($rel->save()) {
                return new responseTags($rel);
            }
        }

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
    public function destroy(Request $request)
    {
        $id = Auth::user()->id;
        if (!empty($request->tagName)) {
            $tag = Tags::checkTags($request->tagName)->first();
            if (!empty($tag)) {
                $rel = UserTagsRel::where('tagID', '=', $tag->tagID)->where('userID', '=', $id)->first();
                if ($rel->delete()) {
                    return new responseTags($rel);
                }
            }
        }
    }
}
