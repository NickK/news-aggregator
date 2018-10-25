<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Can be removed if not used
use \App\NewsSummary as NewsSummary;
use \App\UserSourcesRel as UserSourcesRel;

use Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()) {
            $userID = Auth::user()->id;
            // $links = UserSourcesRel::with(['sources'])
            //                 ->get();
            $links = NewsSummary::with(['tags'])
                        ->join('sourceLinks', 'newsSummary.sourceLinkID', '=', 'sourceLinks.sourceLinkID')
                        ->join('sources', 'sourceLinks.sourceID', '=', 'sources.sourceID')
                        ->where('newsSummary.userID', $userID)
                        ->where('active', 1)
                        ->orderBy('points', 'DESC')
                        ->orderBy('sourceDate', 'DESC')
                        ->get();
            return view('home', ['links' => $links]);
        }



        if(!Auth::check()) {
            $links = NewsSummary::with(['tags'])
                        ->join('sourceLinks', 'newsSummary.sourceLinkID', '=', 'sourceLinks.sourceLinkID')
                        ->join('sources', 'sourceLinks.sourceID', '=', 'sources.sourceID')
                        ->where('newsSummary.userID', 1)
                        ->where('active', 1)
                        ->orderBy('points', 'DESC')
                        ->orderBy('sourceDate', 'DESC')
                        ->get();
            return view('home', ['links' => $links]);

            return view('welcome');
        }

    }
}
