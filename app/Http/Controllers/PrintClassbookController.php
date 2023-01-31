<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrintClassbookController extends Controller
{
    function show(Request $request, $subject){
        $config = \App\Models\Config::where('group', 'main')->get()->pluck('value', 'id')->toArray();
        $classbooks=\App\Models\Classbook::where('subject_id',$subject)->get();
        $data=[];
        $data['subject']=\App\Models\Subject::find($subject);
        $data['user']=auth()->user();
        return view('printClassbook', compact(['classbooks','data','config']));
    }
}